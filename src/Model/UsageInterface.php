<?php

namespace Scn\DeeplApiConnector\Model;

/**
 * Interface UsageInterface
 *
 * @package Scn\DeeplApiConnector\Model
 */
interface UsageInterface
{

    /**
     * @return int
     */
    public function getCharacterCount();

    /**
     * @param int $characterCount
     *
     * @return Usage
     */
    public function setCharacterCount($characterCount);

    /**
     * @return int
     */
    public function getCharacterLimit();

    /**
     * @param int $characterLimit
     *
     * @return Usage
     */
    public function setCharacterLimit($characterLimit);
}