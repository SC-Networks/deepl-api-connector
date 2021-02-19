<?php

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamInterface;

interface DeeplRequestHandlerInterface
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    public function getMethod(): string;

    public function getPath(): string;

    public function getBody(): StreamInterface;
    
    public function getContentType(): string;
}
