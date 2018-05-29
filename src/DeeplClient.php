<?php

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
use Scn\DeeplApiConnector\Model\UsageInterface;

/**
 * Class DeeplClient
 *
 * @package Scn\DeeplApiConnector
 */
class DeeplClient implements DeeplClientInterface
{

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var DeeplRequestFactoryInterface
     */
    private $requestFactory;

    /**
     * DeeplClient constructor.
     *
     * @param ClientInterface $httpClient
     * @param DeeplRequestFactoryInterface $requestFactory
     */
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
     * @return ResponseModelInterface
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUsage()
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
     * @param TranslationConfigInterface $translation
     *
     * @return ResponseModelInterface
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTranslation(TranslationConfigInterface $translation)
    {
        return (new Translation())->hydrate($this->executeRequest(
            $this->requestFactory->createDeeplTranslationRequestHandler($translation)
        ));
    }

    /**
     * @param string $apiKey
     *
     * @return DeeplClient
     */
    public static function create($apiKey)
    {
        return new DeeplClient(
            new \GuzzleHttp\Client(),
            new Handler\DeeplRequestFactory($apiKey)
        );
    }

    /**
     * Return TranslationConfig for given Text / Target Language with Default TranslationConfig Configuration
     *
     * @param string $text
     * @param string $target_language
     *
     * @return ResponseModelInterface
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function translate($text, $target_language)
    {
        $translation = new TranslationConfig($text, $target_language);

        return $this->getTranslation($translation);
    }

    /**
     * Execute given RequestHandler Request and returns decoded Json Object or throws Exception with Error Code
     * and maybe given Error Message
     *
     * @param DeeplRequestHandlerInterface $requestHandler
     *
     * @return \stdClass
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function executeRequest(DeeplRequestHandlerInterface $requestHandler)
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
