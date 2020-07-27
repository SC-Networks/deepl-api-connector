<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Scn\DeeplApiConnector\Exception\RequestException;
use Scn\DeeplApiConnector\Handler\DeeplRequestFactoryInterface;
use Scn\DeeplApiConnector\Handler\DeeplRequestHandlerInterface;
use Scn\DeeplApiConnector\Model\FileSubmission;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslation;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\FileTranslationStatus;
use Scn\DeeplApiConnector\Model\ResponseModelInterface;
use Scn\DeeplApiConnector\Model\Translation;
use Scn\DeeplApiConnector\Model\TranslationConfig;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;
use Scn\DeeplApiConnector\Model\Usage;

class DeeplClient implements DeeplClientInterface
{
    private $httpClient;

    private $requestFactory;

    public function __construct(ClientInterface $httpClient, DeeplRequestFactoryInterface $requestFactory)
    {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    /**
     * Return Usage of API- Key
     * Possible Return:.
     *
     * Usage
     *      -> characterCount 123
     *      -> characterLimit 5647
     *
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUsage(): ResponseModelInterface
    {
        return (new Usage())->hydrate(
            $this->executeRequest($this->requestFactory->createDeeplUsageRequestHandler())
        );
    }

    /**
     * Return TranslationConfig from given TranslationConfig Object
     * Possible Return:.
     *
     * Translation
     *      -> detectedSourceLanguage EN
     *                -> text some translated text
     *
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTranslation(TranslationConfigInterface $translation): ResponseModelInterface
    {
        return (new Translation())->hydrate($this->executeRequest(
            $this->requestFactory->createDeeplTranslationRequestHandler($translation)
        ));
    }

    public static function create($apiKey): DeeplClientInterface
    {
        return new DeeplClient(
            new \GuzzleHttp\Client(),
            new Handler\DeeplRequestFactory($apiKey)
        );
    }

    /**
     * Return TranslationConfig for given Text / Target Language with Default TranslationConfig Configuration.
     *
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function translate(string $text, string $target_language): ResponseModelInterface
    {
        $translation = new TranslationConfig($text, $target_language);

        return $this->getTranslation($translation);
    }

    public function translateFile(FileTranslationConfigInterface $fileTranslation): ResponseModelInterface
    {
        return (new FileSubmission())->hydrate($this->executeRequest(
            $this->requestFactory->createDeeplFileSubmissionRequestHandler($fileTranslation)
        ));
    }

    public function getFileTranslationStatus(FileSubmissionInterface $fileSubmission): ResponseModelInterface
    {
        return (new FileTranslationStatus())->hydrate($this->executeRequest(
            $this->requestFactory->createDeeplFileTranslationStatusRequestHandler($fileSubmission)
        ));
    }

    public function getFileTranslation(FileSubmissionInterface $fileSubmission): ResponseModelInterface
    {
        return (new FileTranslation())->hydrate($this->executeRequest(
            $this->requestFactory->createDeeplFileTranslationRequestHandler($fileSubmission)
        ));
    }

    /**
     * Execute given RequestHandler Request and returns decoded Json Object or throws Exception with Error Code
     * and maybe given Error Message.
     *
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function executeRequest(DeeplRequestHandlerInterface $requestHandler): \stdClass
    {
        try {
            $response = $this->httpClient->request(
                $requestHandler->getMethod(),
                $requestHandler->getPath(),
                $requestHandler->getBody()
            );

            if (in_array('application/json', $response->getHeader('Content-Type'))) {
                return json_decode($response->getBody()->getContents());
            } else {
                $content = new \stdClass();
                $content->content = $response->getBody()->getContents();

                return $content;
            }
        } catch (ClientExceptionInterface $exception) {
            throw new RequestException(
                $exception->getCode().
                ' '.
                $exception->getResponse()->getBody()->getContents()
            );
        }
    }
}
