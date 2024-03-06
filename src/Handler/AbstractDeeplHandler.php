<?php

namespace Scn\DeeplApiConnector\Handler;

abstract class AbstractDeeplHandler implements DeeplRequestHandlerInterface
{
    public function getAuthHeader(): ?string
    {
        return null;
    }

    public function getAcceptHeader(): ?string
    {
        return null;
    }
}
