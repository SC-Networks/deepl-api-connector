<?php

namespace Scn\DeeplApiConnector\Model;

interface ResponseModelInterface
{
    public function hydrate(\stdClass $responseModel): ResponseModelInterface;
}
