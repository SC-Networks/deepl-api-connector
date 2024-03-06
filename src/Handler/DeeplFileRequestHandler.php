<?php

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;

final class DeeplFileRequestHandler extends AbstractDeeplHandler
{
    public const API_ENDPOINT = '/v2/document/%s/result';

    private string $authKey;

    private StreamFactoryInterface $streamFactory;

    private FileSubmissionInterface $fileSubmission;

    public function __construct(
        string $authKey,
        StreamFactoryInterface $streamFactory,
        FileSubmissionInterface $fileSubmission
    ) {
        $this->authKey = $authKey;
        $this->streamFactory = $streamFactory;
        $this->fileSubmission = $fileSubmission;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_POST;
    }

    public function getPath(): string
    {
        return sprintf(static::API_ENDPOINT, $this->fileSubmission->getDocumentId());
    }

    public function getBody(): StreamInterface
    {
        return $this->streamFactory->createStream(
            http_build_query(
                array_filter(
                    [
                        'auth_key' => $this->authKey,
                        'document_key' => $this->fileSubmission->getDocumentKey(),
                    ]
                )
            )
        );
    }

    public function getContentType(): string
    {
        return 'application/x-www-form-urlencoded';
    }
}
