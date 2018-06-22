<?php

namespace Scn\DeeplApiConnector\Model;

/**
 * Interface TranslationInterface
 *
 * @package Scn\DeeplApiConnector\Model
 */
interface TranslationInterface
{
    /**
     * @return string
     */
    public function getDetectedSourceLanguage();

    /**
     * @param string $detectedSourceLanguage
     *
     * @return Translation
     */
    public function setDetectedSourceLanguage($detectedSourceLanguage);

    /**
     * @return string
     */
    public function getText();

    /**
     * @param string $text
     *
     * @return Translation
     */
    public function setText($text);

}