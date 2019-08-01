<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

final class Translation extends AbstractResponseModel implements TranslationInterface
{
    private $detectedSourceLanguage;

    private $text;

    public function getDetectedSourceLanguage(): string
    {
        return $this->detectedSourceLanguage;
    }

    public function setDetectedSourceLanguage(string $detectedSourceLanguage): TranslationInterface
    {
        $this->detectedSourceLanguage = $detectedSourceLanguage;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): TranslationInterface
    {
        $this->text = $text;

        return $this;
    }
}
