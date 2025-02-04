<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

final class DeeplUsageRequestHandler extends AbstractDeeplHandler
{
    public const API_ENDPOINT = '/v2/usage';

    private StreamFactoryInterface $streamFactory;

    public function __construct(
        StreamFactoryInterface $streamFactory,
    ) {
        $this->streamFactory = $streamFactory;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_GET;
    }

    public function getPath(): string
    {
        return self::API_ENDPOINT;
    }

    public function getBody(): StreamInterface
    {
        return $this->streamFactory->createStream();
    }
}
