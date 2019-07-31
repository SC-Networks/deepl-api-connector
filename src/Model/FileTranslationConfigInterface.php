<?php

namespace Scn\DeeplApiConnector\Model;

interface FileTranslationConfigInterface
{
    public function getFileContent(): string;

    public function setFileContent(string $fileContent): FileTranslationConfigInterface;

    public function getFileName(): string;

    public function setFileName(string $fileName): FileTranslationConfigInterface;

    public function getTargetLang(): string;

    public function setTargetLang(string $targetLang): FileTranslationConfigInterface;

    public function getSourceLang(): string;

    public function setSourceLang(string $sourceLang): FileTranslationConfigInterface;
}
