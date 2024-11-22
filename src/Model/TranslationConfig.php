<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\Enum\TextHandlingEnum;

final class TranslationConfig implements TranslationConfigInterface
{
    private string $text;

    private string $targetLang;

    private string $sourceLang;

    /** @var array<int, string> */
    private array $tagHandling;

    /** @var array<int, string> */
    private array $nonSplittingTags;

    /** @var array<int, string> */
    private array $ignoreTags;

    private string $splitSentences;

    private string $preserveFormatting;

    private string $glossaryId;

    /**
     * @param array<int, string> $tagHandling
     * @param array<int, string> $nonSplittingTags
     * @param array<int, string> $ignoreTags
     */
    public function __construct(
        string $text,
        string $targetLang,
        string $sourceLang = '',
        array $tagHandling = [],
        array $nonSplittingTags = [],
        array $ignoreTags = [],
        string $splitSentences = TextHandlingEnum::SPLITSENTENCES_ON,
        string $preserveFormatting = TextHandlingEnum::PRESERVEFORMATTING_OFF,
        string $glossaryId = ''
    ) {
        $this->setText($text);
        $this->setTargetLang($targetLang);
        $this->setSourceLang($sourceLang);
        $this->setTagHandling($tagHandling);
        $this->setNonSplittingTags($nonSplittingTags);
        $this->setIgnoreTags($ignoreTags);
        $this->setSplitSentences($splitSentences);
        $this->setPreserveFormatting($preserveFormatting);
        $this->setGlossaryId($glossaryId);
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): TranslationConfigInterface
    {
        $this->text = $text;

        return $this;
    }

    public function getTargetLang(): string
    {
        return $this->targetLang;
    }

    public function setTargetLang(string $targetLang): TranslationConfigInterface
    {
        $this->targetLang = $targetLang;

        return $this;
    }

    public function getSourceLang(): string
    {
        return $this->sourceLang;
    }

    public function setSourceLang(string $sourceLang): TranslationConfigInterface
    {
        $this->sourceLang = $sourceLang;

        return $this;
    }

    public function getTagHandling(): array
    {
        return $this->tagHandling;
    }

    public function setTagHandling(array $tagHandling): TranslationConfigInterface
    {
        $this->tagHandling = $tagHandling;

        return $this;
    }

    public function getNonSplittingTags(): array
    {
        return $this->nonSplittingTags;
    }

    public function setNonSplittingTags(array $nonSplittingTags): TranslationConfigInterface
    {
        $this->nonSplittingTags = $nonSplittingTags;

        return $this;
    }

    public function getIgnoreTags(): array
    {
        return $this->ignoreTags;
    }

    public function setIgnoreTags(array $ignoreTags): TranslationConfigInterface
    {
        $this->ignoreTags = $ignoreTags;

        return $this;
    }

    public function getSplitSentences(): string
    {
        return $this->splitSentences;
    }

    public function setSplitSentences(string $splitSentences): TranslationConfigInterface
    {
        $this->splitSentences = $splitSentences;

        return $this;
    }

    public function getPreserveFormatting(): string
    {
        return $this->preserveFormatting;
    }

    public function setPreserveFormatting(string $preserveFormatting): TranslationConfigInterface
    {
        $this->preserveFormatting = $preserveFormatting;

        return $this;
    }

    public function getGlossaryId(): string
    {
        return $this->glossaryId;
    }

    public function setGlossaryId(string $glossaryId): TranslationConfigInterface
    {
        $this->glossaryId = $glossaryId;

        return $this;
    }
}
