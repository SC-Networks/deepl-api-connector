<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\GlossarySubmissionInterface;

final class DeeplGlossaryCreateRequestHandler extends AbstractDeeplHandler
{
    public const API_ENDPOINT = '/v2/glossaries';

    private StreamFactoryInterface $streamFactory;

    private GlossarySubmissionInterface $submission;

    public function __construct(
        StreamFactoryInterface $streamFactory,
        GlossarySubmissionInterface $submission,
    ) {
        $this->streamFactory = $streamFactory;
        $this->submission = $submission;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_POST;
    }

    public function getPath(): string
    {
        return self::API_ENDPOINT;
    }

    public function getBody(): StreamInterface
    {
        return $this->streamFactory->createStream(
            json_encode(
                array_filter(
                    $this->submission->toArrayRequest(),
                ),
                JSON_THROW_ON_ERROR
            ),
        );
    }
}
