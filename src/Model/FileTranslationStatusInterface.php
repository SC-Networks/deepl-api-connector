<?php

namespace Scn\DeeplApiConnector\Model;

interface FileTranslationStatusInterface
{
    public function getDocumentId(): string;

    public function setDocumentId(string $documentId): FileTranslationStatusInterface;

    public function getStatus(): string;

    public function setStatus(string $status): FileTranslationStatusInterface;

    public function getSecondsRemaining(): ?int;

    public function setSecondsRemaining(?int $secondsRemaining): FileTranslationStatusInterface;

    public function getBilledCharacters(): int;

    public function setBilledCharacters(int $billedCharacters): FileTranslationStatusInterface;
}
