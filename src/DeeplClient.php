<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Scn\DeeplApiConnector\Exception\RequestException;
use Scn\DeeplApiConnector\Handler\DeeplRequestFactoryInterface;
use Scn\DeeplApiConnector\Handler\DeeplRequestHandlerInterface;
use Scn\DeeplApiConnector\Model\ResponseModelInterface;
use Scn\DeeplApiConnector\Model\Translation;
use Scn\DeeplApiConnector\Model\TranslationConfig;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;
use Scn\DeeplApiConnector\Model\Usage;

/**
 * Class DeeplClient
 *
 * @package Scn\DeeplApiConnector
 */
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
     * Possible Return:
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
     * Possible Return:
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
     * Return TranslationConfig for given Text / Target Language with Default TranslationConfig Configuration
     *
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function translate(string $text, string $target_language): ResponseModelInterface
    {
        $translation = new TranslationConfig($text, $target_language);

        return $this->getTranslation($translation);
    }

    /**
     * Execute given RequestHandler Request and returns decoded Json Object or throws Exception with Error Code
     * and maybe given Error Message
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

            return \GuzzleHttp\json_decode($response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new RequestException(
                $exception->getCode() .
                ' ' .
                $exception->getResponse()->getBody()->getContents()
            );
        }
    }
}
