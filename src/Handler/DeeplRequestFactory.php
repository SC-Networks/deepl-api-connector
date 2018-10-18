<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

/**
 * Class DeeplRequestFactory
 *
 * @package Scn\DeeplApiConnector\Handler
 */
final class DeeplRequestFactory implements DeeplRequestFactoryInterface
{

    private $authKey;

    public function __construct(string $authKey)
    {
        $this->authKey = $authKey;
    }

    public function createDeeplTranslationRequestHandler(TranslationConfigInterface $translation): DeeplRequestHandlerInterface
    {
        return new DeeplTranslationRequestHandler($this->authKey, $translation);
    }

    public function createDeeplUsageRequestHandler(): DeeplRequestHandlerInterface
    {
        return new DeeplUsageRequestHandler($this->authKey);
    }
}