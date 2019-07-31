<?php declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

final class FileTranslation extends AbstractResponseModel implements FileTranslationInterface
{
    private $content;

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): FileTranslationInterface
    {
        $this->content = $content;
        return $this;
    }
}
