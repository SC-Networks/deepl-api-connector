<?php

namespace Scn\DeeplApiConnector\Model;

/**
 * Interface ResponseModelInterface
 *
 * @package Scn\DeeplApiConnector\Model
 */
interface ResponseModelInterface
{

    /**
     * @param \stdClass $responseModel
     *
     * @return ResponseModelInterface
     */
    public function hydrate(\stdClass $responseModel);

}