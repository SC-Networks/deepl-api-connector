<?php

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

    /**
     *
     * @return string
     */
    public function getMethod();

    /**
     *
     * @return string
     */
    public function getPath();

    /**
     *
     * @return array
     */
    public function getBody();
}