<?php

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

/**
 * Class DeeplRequestFactory
 *
 * @package Scn\DeeplApiConnector\Handler
 */
final class DeeplRequestFactory implements DeeplRequestFactoryInterface
{

    /**
     * @var string
     */
    private $authKey;

    /**
     * DeeplRequestFactory constructor.
     *
     * @param string $authKey
     */
    public function __construct($authKey)
    {
        $this->authKey = $authKey;
    }

    /**
     * @param TranslationConfigInterface $translation
     *
     * @return DeeplTranslationRequestHandler
     */
    public function createDeeplTranslationRequestHandler(TranslationConfigInterface $translation)
    {
        return new DeeplTranslationRequestHandler($this->authKey, $translation);
    }

    /**
     *
     * @return DeeplUsageRequestHandler
     */
    public function createDeeplUsageRequestHandler()
    {
        return new DeeplUsageRequestHandler($this->authKey);
    }
}