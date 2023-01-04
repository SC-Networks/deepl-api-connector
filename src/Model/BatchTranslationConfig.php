<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\Enum\TextHandlingEnum;

final class BatchTranslationConfig implements BatchTranslationConfigInterface
{
    /** @var array<string> */
    private array $text;

    private string $targetLang;

    /** @var array<int, string> */
    private array $tagHandling;

    /** @var array<int, string> */
    private array $nonSplittingTags;

    /** @var array<int, string> */
    private array $ignoreTags;

    private string $splitSentences;

    private string $preserveFormatting;

    /**
     * @param array<string> $text
     * @param array<int, string> $tagHandling
     * @param array<int, string> $nonSplittingTags
     * @param array<int, string> $ignoreTags
     */
    public function __construct(
        array $text,
        string $targetLang,
        array $tagHandling = [],
        array $nonSplittingTags = [],
        array $ignoreTags = [],
        string $splitSentences = TextHandlingEnum::SPLITSENTENCES_ON,
        string $preserveFormatting = TextHandlingEnum::PRESERVEFORMATTING_OFF
    ) {
        $this->setText($text);
        $this->setTargetLang($targetLang);
        $this->setTagHandling($tagHandling);
        $this->setNonSplittingTags($nonSplittingTags);
        $this->setIgnoreTags($ignoreTags);
        $this->setSplitSentences($splitSentences);
        $this->setPreserveFormatting($preserveFormatting);
    }

    /**
     * @return array<string>
     */
    public function getText(): array
    {
        return $this->text;
    }

    /**
     * @param array<string> $text
     */
    public function setText(array $text): BatchTranslationConfigInterface
    {
        $this->text = $text;

        return $this;
    }

    public function getTargetLang(): string
    {
        return $this->targetLang;
    }

    public function setTargetLang(string $targetLang): BatchTranslationConfigInterface
    {
        $this->targetLang = $targetLang;

        return $this;
    }

    public function getTagHandling(): array
    {
        return $this->tagHandling;
    }

    public function setTagHandling(array $tagHandling): BatchTranslationConfigInterface
    {
        $this->tagHandling = $tagHandling;

        return $this;
    }

    public function getNonSplittingTags(): array
    {
        return $this->nonSplittingTags;
    }

    public function setNonSplittingTags(array $nonSplittingTags): BatchTranslationConfigInterface
    {
        $this->nonSplittingTags = $nonSplittingTags;

        return $this;
    }

    public function getIgnoreTags(): array
    {
        return $this->ignoreTags;
    }

    public function setIgnoreTags(array $ignoreTags): BatchTranslationConfigInterface
    {
        $this->ignoreTags = $ignoreTags;

        return $this;
    }

    public function getSplitSentences(): string
    {
        return $this->splitSentences;
    }

    public function setSplitSentences(string $splitSentences): BatchTranslationConfigInterface
    {
        $this->splitSentences = $splitSentences;

        return $this;
    }

    public function getPreserveFormatting(): string
    {
        return $this->preserveFormatting;
    }

    public function setPreserveFormatting(string $preserveFormatting): BatchTranslationConfigInterface
    {
        $this->preserveFormatting = $preserveFormatting;

        return $this;
    }
}
