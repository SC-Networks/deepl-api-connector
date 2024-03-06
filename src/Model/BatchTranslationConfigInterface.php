<?php

namespace Scn\DeeplApiConnector\Model;

interface BatchTranslationConfigInterface
{
    /**
     * @return array<string>
     */
    public function getText(): array;

    /**
     * @param array<string> $text
     */
    public function setText(array $text): BatchTranslationConfigInterface;

    public function getTargetLang(): string;

    public function setTargetLang(string $targetLang): BatchTranslationConfigInterface;

    /**
     * @return array<string>
     */
    public function getTagHandling(): array;

    /**
     * @param array<string> $tagHandling
     */
    public function setTagHandling(array $tagHandling): BatchTranslationConfigInterface;

    /**
     * @return array<string>
     */
    public function getNonSplittingTags(): array;

    /**
     * @param array<string> $nonSplittingTags
     */
    public function setNonSplittingTags(array $nonSplittingTags): BatchTranslationConfigInterface;

    /**
     * @return array<string>
     */
    public function getIgnoreTags(): array;

    /**
     * @param array<string> $ignoreTags
     */
    public function setIgnoreTags(array $ignoreTags): BatchTranslationConfigInterface;

    public function getSplitSentences(): string;

    public function setSplitSentences(string $splitSentences): BatchTranslationConfigInterface;

    public function getPreserveFormatting(): string;

    public function setPreserveFormatting(string $preserveFormatting): BatchTranslationConfigInterface;

    public function getGlossaryId(): string;

    public function setGlossaryId(string $glossaryId): BatchTranslationConfigInterface;
}
