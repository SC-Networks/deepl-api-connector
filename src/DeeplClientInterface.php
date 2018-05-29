<?php

namespace Scn\DeeplApiConnector;

use Scn\DeeplApiConnector\Exception\RequestException;
use Scn\DeeplApiConnector\Model\ResponseModelInterface;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;
use Scn\DeeplApiConnector\Model\UsageInterface;

/**
 * Class DeeplClientInterface
 *
 * @package Scn\DeeplApiConnector
 */
interface DeeplClientInterface
{

    /**
     * @return ResponseModelInterface
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUsage();

    /**
     * @param TranslationConfigInterface $translation
     *
     * @return ResponseModelInterface
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTranslation(TranslationConfigInterface $translation);


    /**
     * @param string $text
     * @param string $target_language
     *
     * @return ResponseModelInterface
     */
    public function translate($text, $target_language);

    /**
     * @param string $apiKey
     *
     * @return DeeplClient
     */
    public static function create($apiKey);
}