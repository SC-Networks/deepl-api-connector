<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

/**
 * Interface TranslationRequestHandlerInterface
 *
 * @package Scn\DeeplApiConnector\Handler
 */
interface DeeplRequestHandlerInterface
{

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    public function getMethod(): string;

    public function getPath(): string;

    public function getBody(): array;
}