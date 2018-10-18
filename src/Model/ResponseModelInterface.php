<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

/**
 * Interface ResponseModelInterface
 *
 * @package Scn\DeeplApiConnector\Model
 */
interface ResponseModelInterface
{
    public function hydrate(\stdClass $responseModel): ResponseModelInterface;
}