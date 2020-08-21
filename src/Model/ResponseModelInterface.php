<?php

namespace Scn\DeeplApiConnector\Model;

use stdClass;

interface ResponseModelInterface
{
    public function hydrate(stdClass $responseModel): ResponseModelInterface;
}
