<?php

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

    /**
     * @return string
     */
    public function getText();

    /**
     * @param string $text
     *
     * @return TranslationConfigInterface
     */
    public function setText($text);

    /**
     * @return string
     */
    public function getTargetLang();

    /**
     * @param string $targetLang
     *
     * @return TranslationConfigInterface
     */
    public function setTargetLang($targetLang);

    /**
     * @return string
     */
    public function getSourceLang();

    /**
     * @param string $sourceLang
     *
     * @return TranslationConfigInterface
     */
    public function setSourceLang($sourceLang);

    /**
     * @return string[]
     */
    public function getTagHandling();

    /**
     * @param string[] $tagHandling
     *
     * @return TranslationConfigInterface
     */
    public function setTagHandling(array $tagHandling);

    /**
     * @return string[]
     */
    public function getNonSplittingTags();

    /**
     * @param string[] $nonSplittingTags
     *
     * @return TranslationConfigInterface
     */
    public function setNonSplittingTags(array $nonSplittingTags);

    /**
     * @return string[]
     */
    public function getIgnoreTags();

    /**
     * @param string[] $ignoreTags
     *
     * @return TranslationConfigInterface
     */
    public function setIgnoreTags(array $ignoreTags);

    /**
     * @return bool
     */
    public function getSplitSentences();

    /**
     * @param bool $splitSentences
     *
     * @return TranslationConfigInterface
     */
    public function setSplitSentences($splitSentences);

    /**
     * @return bool
     */
    public function getPreserveFormatting();

    /**
     * @param bool $preserveFormatting
     *
     * @return TranslationConfigInterface
     */
    public function setPreserveFormatting($preserveFormatting);
}