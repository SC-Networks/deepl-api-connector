<?php

namespace Scn\DeeplApiConnector\Model;

/**
 * Class Translation
 *
 * @package Scn\DeeplApiConnector\Model
 */
final class Translation extends AbstractResponseModel implements TranslationInterface
{

    /**
     * @var string
     */
    private $detectedSourceLanguage;

    /**
     * @var string
     */
    private $text;

    /**
     * @return string
     */
    public function getDetectedSourceLanguage()
    {
        return $this->detectedSourceLanguage;
    }

    /**
     * @param string $detectedSourceLanguage
     *
     * @return Translation
     */
    public function setDetectedSourceLanguage($detectedSourceLanguage)
    {
        $this->detectedSourceLanguage = $detectedSourceLanguage;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return Translation
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}