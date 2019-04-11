<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

/**
 * Interface TranslationConfigInterface
 *
 * @package Scn\DeeplApiConnector\Model
 */
interface TranslationConfigInterface
{

    const LANGUAGE_EN = 'EN';
    const LANGUAGE_DE = 'DE';
    const LANGUAGE_FR = 'FR';
    const LANGUAGE_ES = 'ES';
    const LANGUAGE_IT = 'IT';
    const LANGUAGE_NL = 'NL';
    const LANGUAGE_PL = 'PL';
    const LANGUAGE_PT = 'PT';
    const LANGUAGE_RU = 'RU';

    public function getText(): string;

    public function setText(string $text): TranslationConfigInterface;

    public function getTargetLang(): string;

    public function setTargetLang(string $targetLang): TranslationConfigInterface;

    public function getSourceLang(): string;

    public function setSourceLang(string $sourceLang): TranslationConfigInterface;

    public function getTagHandling(): array;

    public function setTagHandling(array $tagHandling): TranslationConfigInterface;

    public function getNonSplittingTags(): array;

    public function setNonSplittingTags(array $nonSplittingTags): TranslationConfigInterface;

    public function getIgnoreTags(): array;

    public function setIgnoreTags(array $ignoreTags): TranslationConfigInterface;

    public function getSplitSentences(): bool;

    public function setSplitSentences(bool $splitSentences): TranslationConfigInterface;

    public function getPreserveFormatting(): bool;

    public function setPreserveFormatting(bool $preserveFormatting): TranslationConfigInterface;
}