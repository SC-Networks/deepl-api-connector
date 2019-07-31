<?php

namespace Scn\DeeplApiConnector\Model;

interface FileTranslationInterface
{
    public function getContent(): string;

    public function setContent(string $content): FileTranslationInterface;
}
