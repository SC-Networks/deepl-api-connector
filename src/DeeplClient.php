<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Scn\DeeplApiConnector\Exception\RequestException;
use Scn\DeeplApiConnector\Handler\DeeplRequestFactoryInterface;
use Scn\DeeplApiConnector\Handler\DeeplRequestHandlerInterface;
use Scn\DeeplApiConnector\Model\BatchTranslation;
use Scn\DeeplApiConnector\Model\BatchTranslationConfig;
use Scn\DeeplApiConnector\Model\FileSubmission;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslation;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\FileTranslationStatus;
use Scn\DeeplApiConnector\Model\GlossariesList;
use Scn\DeeplApiConnector\Model\GlossariesSupportedLanguagesPairs;
use Scn\DeeplApiConnector\Model\ResponseModelInterface;
use Scn\DeeplApiConnector\Model\SupportedLanguages;
use Scn\DeeplApiConnector\Model\Translation;
use Scn\DeeplApiConnector\Model\TranslationConfig;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;
use Scn\DeeplApiConnector\Model\Usage;
use stdClass;

class DeeplClient implements DeeplClientInterface
{
    private DeeplRequestFactoryInterface $deeplRequestFactory;

    private ClientInterface $httpClient;

    private RequestFactoryInterface $requestFactory;

    public function __construct(
        DeeplRequestFactoryInterface $deeplRequestFactory,
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory
    ) {
        $this->deeplRequestFactory = $deeplRequestFactory;
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
     */
    public function getUsage(): ResponseModelInterface
    {
        return (new Usage())->hydrate(
            $this->executeRequest($this->deeplRequestFactory->createDeeplUsageRequestHandler())
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
     */
    public function getTranslation(TranslationConfigInterface $translation): ResponseModelInterface
    {
        return (new Translation())->hydrate($this->executeRequest(
            $this->deeplRequestFactory->createDeeplTranslationRequestHandler($translation)
        ));
    }

    /**
     * Return TranslationConfig for given Text / Target Language with Default TranslationConfig Configuration.
     *
     * @throws RequestException
     */
    public function translate(string $text, string $target_language): ResponseModelInterface
    {
        $translation = new TranslationConfig($text, $target_language);

        return $this->getTranslation($translation);
    }

    public function translateFile(FileTranslationConfigInterface $fileTranslation): ResponseModelInterface
    {
        return (new FileSubmission())->hydrate($this->executeRequest(
            $this->deeplRequestFactory->createDeeplFileSubmissionRequestHandler($fileTranslation)
        ));
    }

    public function translateBatch(array $text, string $targetLanguage): ResponseModelInterface
    {
        return (new BatchTranslation())->hydrate($this->executeRequest(
            $this->deeplRequestFactory->createDeeplBatchTranslationRequestHandler(
                new BatchTranslationConfig($text, $targetLanguage)
            )
        ));
    }

    public function getFileTranslationStatus(FileSubmissionInterface $fileSubmission): ResponseModelInterface
    {
        return (new FileTranslationStatus())->hydrate($this->executeRequest(
            $this->deeplRequestFactory->createDeeplFileTranslationStatusRequestHandler($fileSubmission)
        ));
    }

    public function getFileTranslation(FileSubmissionInterface $fileSubmission): ResponseModelInterface
    {
        return (new FileTranslation())->hydrate($this->executeRequest(
            $this->deeplRequestFactory->createDeeplFileTranslationRequestHandler($fileSubmission)
        ));
    }

    public function getSupportedLanguages(): ResponseModelInterface
    {
        return (new SupportedLanguages())->hydrate(
            $this->executeRequest(
                $this->deeplRequestFactory->createDeeplSupportedLanguageRetrievalRequestHandler()
            )
        );
    }

    public function getGlossariesSupportedLanguagesPairs(): ResponseModelInterface
    {
        return (new GlossariesSupportedLanguagesPairs())->hydrate(
            $this->executeRequest(
                $this->deeplRequestFactory->createDeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler()
            )
        );
    }

    public function getGlossariesList(): ResponseModelInterface
    {
        return (new GlossariesList())->hydrate(
            $this->executeRequest(
                $this->deeplRequestFactory->createDeeplGlossariesListRetrievalRequestHandler()
            )
        );
    }

    /**
     * Execute given RequestHandler Request and returns decoded Json Object or throws Exception with Error Code
     * and maybe given Error Message.
     *
     * @throws RequestException
     */
    private function executeRequest(DeeplRequestHandlerInterface $requestHandler): stdClass
    {
        // build the actual http request
        $request = $this->requestFactory
            ->createRequest(
                $requestHandler->getMethod(),
                sprintf('%s%s', $this->deeplRequestFactory->getDeeplBaseUri(), $requestHandler->getPath())
            )
            ->withHeader(
                'Content-Type',
                $requestHandler->getContentType()
            )
            ->withBody($requestHandler->getBody());

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $exception) {
            throw new RequestException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        // if the http client doesn't handle errors, catch client- and server errors
        $statusCode = $response->getStatusCode();
        $errorType = substr((string) $statusCode, 0, 1);
        if (in_array($errorType, ['5', '4'], true)) {
            throw new RequestException(
                'Http error occurred',
                $statusCode,
            );
        }

        // Result handling is kinda broken atm
        $headers = (string) json_encode($response->getHeader('Content-Type'));

        if (stripos($headers, 'application\/json') !== false) {
            $result = json_decode($response->getBody()->getContents());

            // json responses having an array on root-level need to be converted (sigh)
            if (is_array($result)) {
                $content = new stdClass();
                $content->content = $result;

                $result = $content;
            }
        } else {
            $content = new stdClass();
            $content->content = $response->getBody()->getContents();

            $result = $content;
        }

        /** @var stdClass $result */
        return $result;
    }
}
