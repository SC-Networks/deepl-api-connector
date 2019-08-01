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

    public function getSplitSentences(): int;

    public function setSplitSentences(int $splitSentences): TranslationConfigInterface;

    public function getPreserveFormatting(): int;

    public function setPreserveFormatting(int $preserveFormatting): TranslationConfigInterface;
}
