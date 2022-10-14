<?php

namespace Scn\DeeplApiConnector\Model;

interface TranslationConfigInterface
{
    public function getText(): string;

    public function setText(string $text): TranslationConfigInterface;

    public function getTargetLang(): string;

    public function setTargetLang(string $targetLang): TranslationConfigInterface;

    public function getSourceLang(): string;

    public function setSourceLang(string $sourceLang): TranslationConfigInterface;

    /**
     * @return array<int, string>
     */
    public function getTagHandling(): array;

    /**
     * @param array<int, string> $tagHandling
     */
    public function setTagHandling(array $tagHandling): TranslationConfigInterface;

    /**
     * @return array<int, string>
     */
    public function getNonSplittingTags(): array;

    /**
     * @param array<int, string> $nonSplittingTags
     */
    public function setNonSplittingTags(array $nonSplittingTags): TranslationConfigInterface;

    /**
     * @return array<int, string>
     */
    public function getIgnoreTags(): array;

    /**
     * @param array<int, string> $ignoreTags
     */
    public function setIgnoreTags(array $ignoreTags): TranslationConfigInterface;

    public function getSplitSentences(): string;

    public function setSplitSentences(string $splitSentences): TranslationConfigInterface;

    public function getPreserveFormatting(): string;

    public function setPreserveFormatting(string $preserveFormatting): TranslationConfigInterface;
}
