<?php

namespace Scn\DeeplApiConnector\Model;

/**
 * Class TranslationConfig
 *
 * @package Scn\DeeplApiConnector\Handler
 */
final class TranslationConfig implements TranslationConfigInterface
{

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $targetLang;

    /**
     * @var string
     */
    private $sourceLang;

    /**
     * @var string[]
     */
    private $tagHandling;

    /**
     * @var string[]
     */
    private $nonSplittingTags;

    /**
     * @var string[]
     */
    private $ignoreTags;

    /**
     * @var bool
     */
    private $splitSentences;

    /**
     * @var bool
     */
    private $preserveFormatting;

    /**
     * TranslationConfig constructor.
     *
     * @param string $text
     * @param string $targetLang
     * @param string $sourceLang
     * @param string[] $tagHandling
     * @param string[] $nonSplittingTags
     * @param string[] $ignoreTags
     * @param bool $splitSentences
     * @param bool $preserveFormatting
     */
    public function __construct(
        $text,
        $targetLang,
        $sourceLang = '',
        $tagHandling = [],
        $nonSplittingTags = [],
        $ignoreTags = [],
        $splitSentences = true,
        $preserveFormatting = false
    ) {
        $this->setText($text);
        $this->setTargetLang($targetLang);
        $this->setSourceLang($sourceLang);
        $this->setTagHandling($tagHandling);
        $this->setNonSplittingTags($nonSplittingTags);
        $this->setIgnoreTags($ignoreTags);
        $this->setSplitSentences($splitSentences);
        $this->setPreserveFormatting($preserveFormatting);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return TranslationConfigInterface
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getTargetLang()
    {
        return $this->targetLang;
    }

    /**
     * @param string $targetLang
     *
     * @return TranslationConfigInterface
     */
    public function setTargetLang($targetLang)
    {
        $this->targetLang = $targetLang;

        return $this;
    }

    /**
     * @return string
     */
    public function getSourceLang()
    {
        return $this->sourceLang;
    }

    /**
     * @param string $sourceLang
     *
     * @return TranslationConfigInterface
     */
    public function setSourceLang($sourceLang)
    {
        $this->sourceLang = $sourceLang;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getTagHandling()
    {
        return $this->tagHandling;
    }

    /**
     * @param string[] $tagHandling
     *
     * @return TranslationConfigInterface
     */
    public function setTagHandling(array $tagHandling)
    {
        $this->tagHandling = $tagHandling;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getNonSplittingTags()
    {
        return $this->nonSplittingTags;
    }

    /**
     * @param string[] $nonSplittingTags
     *
     * @return TranslationConfigInterface
     */
    public function setNonSplittingTags(array $nonSplittingTags)
    {
        $this->nonSplittingTags = $nonSplittingTags;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getIgnoreTags()
    {
        return $this->ignoreTags;
    }

    /**
     * @param string[] $ignoreTags
     *
     * @return TranslationConfigInterface
     */
    public function setIgnoreTags(array $ignoreTags)
    {
        $this->ignoreTags = $ignoreTags;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSplitSentences()
    {
        return $this->splitSentences;
    }

    /**
     * @param bool $splitSentences
     *
     * @return TranslationConfigInterface
     */
    public function setSplitSentences($splitSentences)
    {
        $this->splitSentences = $splitSentences;

        return $this;
    }

    /**
     * @return bool
     */
    public function getPreserveFormatting()
    {
        return $this->preserveFormatting;
    }

    /**
     * @param bool $preserveFormatting
     *
     * @return TranslationConfigInterface
     */
    public function setPreserveFormatting($preserveFormatting)
    {
        $this->preserveFormatting = $preserveFormatting;

        return $this;
    }
}