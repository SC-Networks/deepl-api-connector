<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\GlossarySubmissionInterface;

final class DeeplGlossaryCreateRequestHandler extends AbstractDeeplHandler
{
    public const API_ENDPOINT = '/v2/glossaries';

    private string $authKey;

    private StreamFactoryInterface $streamFactory;

    private GlossarySubmissionInterface $submission;

    public function __construct(
        string $authKey,
        StreamFactoryInterface $streamFactory,
        GlossarySubmissionInterface $submission
    ) {
        $this->authKey = $authKey;
        $this->streamFactory = $streamFactory;
        $this->submission = $submission;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_POST;
    }

    public function getPath(): string
    {
        return static::API_ENDPOINT;
    }

    public function getBody(): StreamInterface
    {
        return $this->streamFactory->createStream(
            http_build_query(
                array_filter(
                    array_merge(
                        $this->submission->toArrayRequest(),
                    )
                )
            )
        );
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
