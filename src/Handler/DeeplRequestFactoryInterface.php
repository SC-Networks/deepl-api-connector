<?php

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

/**
 * Interface DeeplRequestFactoryInterface
 *
 * @package Scn\DeeplApiConnector\Handler
 */
interface DeeplRequestFactoryInterface
{

    /**
     * @param TranslationConfigInterface $translation
     *
     * @return DeeplTranslationRequestHandler
     */
    public function createDeeplTranslationRequestHandler(TranslationConfigInterface $translation);

    /**
     *
     * @return DeeplUsageRequestHandler
     */
    public function createDeeplUsageRequestHandler();
}