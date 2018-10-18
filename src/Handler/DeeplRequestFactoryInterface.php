<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

/**
 * Interface DeeplRequestFactoryInterface
 *
 * @package Scn\DeeplApiConnector\Handler
 */
interface DeeplRequestFactoryInterface
{

    public function createDeeplTranslationRequestHandler(TranslationConfigInterface $translation
    ): DeeplRequestHandlerInterface;

    public function createDeeplUsageRequestHandler(): DeeplRequestHandlerInterface;
}