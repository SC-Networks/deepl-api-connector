<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

abstract class AbstractDeeplHandler implements DeeplRequestHandlerInterface
{
    public function getAcceptHeader(): ?string
    {
        return null;
    }

    public function getContentType(): string
    {
        return 'application/json';
    }
}
