<?php

namespace Scn\DeeplApiConnector;

use Scn\DeeplApiConnector\Enum\LanguageEnum;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\ResponseModelInterface;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

interface DeeplClientInterface
{
    /**
     * Retrieve usage statistics for the supplied auth key
     */
    public function getUsage(): ResponseModelInterface;

    /**
     * Translate a text using an extended config
     */
    public function getTranslation(TranslationConfigInterface $translation): ResponseModelInterface;

    /**
     * Simple translate a string
     *
     * @param string $target_language Language code of the target language
     *
     * @see LanguageEnum
     */
    public function translate(string $text, string $target_language): ResponseModelInterface;

    /**
     * Translate the contents of a file
     *
     * Invokes an asynchronous file translation, returns a document id for further usage
     */
    public function translateFile(FileTranslationConfigInterface $fileTranslation): ResponseModelInterface;

    /**
     * Translate a batch of texts at once
     *
     * The order of the texts will be preserved
     *
     * @param array<string> $text
     */
    public function translateBatch(array $text, string $targetLanguage): ResponseModelInterface;

    /**
     * Checks the state of a file translation job
     */
    public function getFileTranslationStatus(FileSubmissionInterface $fileSubmission): ResponseModelInterface;

    /**
     * Retrieve the result of a file translation job
     */
    public function getFileTranslation(FileSubmissionInterface $fileSubmission): ResponseModelInterface;

    /**
     * Returns list of supported languages
     */
    public function getSupportedLanguages(): ResponseModelInterface;
}
