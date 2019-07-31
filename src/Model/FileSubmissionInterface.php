<?php

namespace Scn\DeeplApiConnector\Model;

interface FileSubmissionInterface
{
    public function getDocumentId(): string;

    public function setDocumentId(string $documentId): FileSubmissionInterface;

    public function getDocumentKey(): string;

    public function setDocumentKey(string $documentKey): FileSubmissionInterface;
}
