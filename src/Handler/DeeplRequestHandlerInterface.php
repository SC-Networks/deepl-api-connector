<?php

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamInterface;

interface DeeplRequestHandlerInterface
{
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';
    public const METHOD_DELETE = 'DELETE';

    public function getMethod(): string;

    public function getPath(): string;

    public function getBody(): StreamInterface;

    public function getContentType(): string;

    public function getAcceptHeader(): ?string;
}
