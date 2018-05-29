<?php

namespace Scn\DeeplApiConnector\Model;

/**
 * Class Usage
 *
 * @package Scn\DeeplApiConnector\Model
 */
final class Usage extends AbstractResponseModel implements UsageInterface
{

    /**
     * @var int
     */
    private $characterCount;


    /**
     * @var int
     */
    private $characterLimit;

    /**
     * @return int
     */
    public function getCharacterCount()
    {
        return $this->characterCount;
    }

    /**
     * @param int $characterCount
     *
     * @return Usage
     */
    public function setCharacterCount($characterCount)
    {
        $this->characterCount = $characterCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getCharacterLimit()
    {
        return $this->characterLimit;
    }

    /**
     * @param int $characterLimit
     *
     * @return Usage
     */
    public function setCharacterLimit($characterLimit)
    {
        $this->characterLimit = $characterLimit;

        return $this;
    }
}