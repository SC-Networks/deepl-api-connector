<?php

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\FileSubmissionInterface;

final class DeeplFileRequestHandler implements DeeplRequestHandlerInterface
{
    const API_ENDPOINT = 'https://api.deepl.com/v2/document/%s/result';

    private $authKey;

    private $fileSubmission;

    public function __construct(string $authKey, FileSubmissionInterface $fileSubmission)
    {
        $this->authKey = $authKey;
        $this->fileSubmission = $fileSubmission;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_GET;
    }

    public function getPath(): string
    {
        return sprintf(static::API_ENDPOINT, $this->fileSubmission->getDocumentId());
    }

    public function getBody(): array
    {
        return [
            'form_params' => array_filter(
                [
                    'auth_key' => $this->authKey,
                    'document_key' => $this->fileSubmission->getDocumentKey()
                ]
            )
        ];
    }
}
