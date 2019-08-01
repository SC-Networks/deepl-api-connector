<?php

namespace Scn\DeeplApiConnector\Model;

interface TranslationInterface
{
    public function getDetectedSourceLanguage(): string;

    public function setDetectedSourceLanguage(string $detectedSourceLanguage): TranslationInterface;

    public function getText(): string;

    public function setText(string $text): TranslationInterface;
}
