<?php declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

final class FileSubmission extends AbstractResponseModel implements FileSubmissionInterface
{
    private $documentId;

    private $documentKey;

    public function getDocumentId(): string
    {
        return $this->documentId;
    }

    public function setDocumentId(string $documentId): FileSubmissionInterface
    {
        $this->documentId = $documentId;
        return $this;
    }

    public function getDocumentKey(): string
    {
        return $this->documentKey;
    }

    public function setDocumentKey(string $documentKey): FileSubmissionInterface
    {
        $this->documentKey = $documentKey;
        return $this;
    }
}
