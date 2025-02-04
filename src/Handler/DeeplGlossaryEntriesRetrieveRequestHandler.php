<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\GlossaryIdSubmissionInterface;

final class DeeplGlossaryEntriesRetrieveRequestHandler extends AbstractDeeplHandler
{
    public const API_ENDPOINT = '/v2/glossaries/%s/entries';

    private StreamFactoryInterface $streamFactory;

    private GlossaryIdSubmissionInterface $submission;

    public function __construct(
        StreamFactoryInterface $streamFactory,
        GlossaryIdSubmissionInterface $submission,
    ) {
        $this->streamFactory = $streamFactory;
        $this->submission = $submission;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_GET;
    }

    public function getPath(): string
    {
        return sprintf(self::API_ENDPOINT, $this->submission->getId());
    }

    public function getBody(): StreamInterface
    {
        return $this->streamFactory->createStream();
    }

    public function getAcceptHeader(): ?string
    {
        return 'text/tab-separated-values';
    }
}
