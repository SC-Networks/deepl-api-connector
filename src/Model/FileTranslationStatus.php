<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

final class FileTranslationStatus extends AbstractResponseModel implements FileTranslationStatusInterface
{
    private $documentId;

    private $status;

    private $secondsRemaining;

    private $billedCharacters;

    public function getDocumentId(): string
    {
        return $this->documentId;
    }

    public function setDocumentId(string $documentId): FileTranslationStatusInterface
    {
        $this->documentId = $documentId;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): FileTranslationStatusInterface
    {
        $this->status = $status;

        return $this;
    }

    public function getSecondsRemaining(): ?int
    {
        return $this->secondsRemaining;
    }

    public function setSecondsRemaining(?int $secondsRemaining): FileTranslationStatusInterface
    {
        $this->secondsRemaining = $secondsRemaining;

        return $this;
    }

    public function getBilledCharacters(): int
    {
        return $this->billedCharacters;
    }

    public function setBilledCharacters(int $billedCharacters): FileTranslationStatusInterface
    {
        $this->billedCharacters = $billedCharacters;

        return $this;
    }
}
