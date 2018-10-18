<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

/**
 * Interface TranslationInterface
 *
 * @package Scn\DeeplApiConnector\Model
 */
interface TranslationInterface
{
    public function getDetectedSourceLanguage(): string;

    public function setDetectedSourceLanguage(string $detectedSourceLanguage): TranslationInterface;

    public function getText(): string;

    public function setText(string $text): TranslationInterface;
}