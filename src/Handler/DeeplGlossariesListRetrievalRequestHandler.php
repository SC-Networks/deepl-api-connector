<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

final class DeeplGlossariesListRetrievalRequestHandler extends AbstractDeeplHandler
{
    public const API_ENDPOINT = '/v2/glossaries';

    private string $authKey;

    private StreamFactoryInterface $streamFactory;

    public function __construct(
        string $authKey,
        StreamFactoryInterface $streamFactory
    ) {
        $this->authKey = $authKey;
        $this->streamFactory = $streamFactory;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_GET;
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
                    [
                        'auth_key' => $this->authKey,
                    ]
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
