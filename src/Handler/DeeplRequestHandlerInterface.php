<?php

namespace Scn\DeeplApiConnector\Handler;

interface DeeplRequestHandlerInterface
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    public function getMethod(): string;

    public function getPath(): string;

    public function getBody(): array;
}
