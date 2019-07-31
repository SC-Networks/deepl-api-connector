<?php declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

final class FileTranslationConfig implements FileTranslationConfigInterface
{
    private $fileContent;

    private $fileName;

    private $targetLang;

    private $sourceLang;

    public function __construct(
        string $fileContent,
        string $fileName,
        string $targetLang,
        string $sourceLang = ''
    )
    {
        $this->setFileContent($fileContent);
        $this->setFileName($fileName);
        $this->setTargetLang($targetLang);
        $this->setSourceLang($sourceLang);
    }

    public function getFileContent(): string
    {
        return $this->fileContent;
    }

    public function setFileContent(string $fileContent): FileTranslationConfigInterface
    {
        $this->fileContent = $fileContent;
        return $this;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): FileTranslationConfigInterface
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getTargetLang(): string
    {
        return $this->targetLang;
    }

    public function setTargetLang(string $targetLang): FileTranslationConfigInterface
    {
        $this->targetLang = $targetLang;
        return $this;
    }

    public function getSourceLang(): string
    {
        return $this->sourceLang;
    }

    public function setSourceLang(string $sourceLang): FileTranslationConfigInterface
    {
        $this->sourceLang = $sourceLang;
        return $this;
    }
}
