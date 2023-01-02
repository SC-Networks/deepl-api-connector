<?php

namespace Scn\DeeplApiConnector;

use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\ResponseModelInterface;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

interface DeeplClientInterface
{
    public function getUsage(): ResponseModelInterface;

    public function getTranslation(TranslationConfigInterface $translation): ResponseModelInterface;

    public function translate(string $text, string $target_language): ResponseModelInterface;

    public function translateFile(FileTranslationConfigInterface $fileTranslation): ResponseModelInterface;

    public function getFileTranslationStatus(FileSubmissionInterface $fileSubmission): ResponseModelInterface;

    public function getFileTranslation(FileSubmissionInterface $fileSubmission): ResponseModelInterface;

    /**
     * Returns list of supported languages
     */
    public function getSupportedLanguages(): ResponseModelInterface;
}
