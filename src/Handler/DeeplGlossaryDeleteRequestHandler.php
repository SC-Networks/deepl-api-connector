<?php

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\GlossaryIdSubmissionInterface;

final class DeeplGlossaryDeleteRequestHandler extends AbstractDeeplHandler
{
    public const API_ENDPOINT = '/v2/glossaries/%s';

    private string $authKey;

    private StreamFactoryInterface $streamFactory;

    private GlossaryIdSubmissionInterface $submission;

    public function __construct(
        string $authKey,
        StreamFactoryInterface $streamFactory,
        GlossaryIdSubmissionInterface $submission
    ) {
        $this->authKey = $authKey;
        $this->streamFactory = $streamFactory;
        $this->submission = $submission;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_DELETE;
    }

    public function getPath(): string
    {
        return sprintf(static::API_ENDPOINT, $this->submission->getId());
    }

    public function getBody(): StreamInterface
    {
        return $this->streamFactory->createStream();
    }

    public function getAuthHeader(): ?string
    {
        return sprintf('DeepL-Auth-Key %s', $this->authKey);
    }

    public function getContentType(): string
    {
        return 'application/x-www-form-urlencoded';
    }
}
