<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;

final class DeeplFileRequestHandler extends AbstractDeeplHandler
{
    public const API_ENDPOINT = '/v2/document/%s/result';

    private StreamFactoryInterface $streamFactory;

    private FileSubmissionInterface $fileSubmission;

    public function __construct(
        StreamFactoryInterface $streamFactory,
        FileSubmissionInterface $fileSubmission,
    ) {
        $this->streamFactory = $streamFactory;
        $this->fileSubmission = $fileSubmission;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_POST;
    }

    public function getPath(): string
    {
        return sprintf(self::API_ENDPOINT, $this->fileSubmission->getDocumentId());
    }

    public function getBody(): StreamInterface
    {
        return $this->streamFactory->createStream(
            json_encode(
                array_filter(
                    [
                        'document_key' => $this->fileSubmission->getDocumentKey(),
                    ],
                ),
                JSON_THROW_ON_ERROR
            ),
        );
    }
}
