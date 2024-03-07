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

    public function getTagHandling(): array;

    public function setTagHandling(array $tagHandling): TranslationConfigInterface;

    public function getNonSplittingTags(): array;

    public function setNonSplittingTags(array $nonSplittingTags): TranslationConfigInterface;

    public function getIgnoreTags(): array;

    public function setIgnoreTags(array $ignoreTags): TranslationConfigInterface;

    public function getSplitSentences(): string;

    public function setSplitSentences(string $splitSentences): TranslationConfigInterface;

    public function getPreserveFormatting(): string;

    public function setPreserveFormatting(string $preserveFormatting): TranslationConfigInterface;

    public function getGlossaryId(): string;

    public function setGlossaryId(string $glossaryId): TranslationConfigInterface;
}
