<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
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

    public function createDeeplTranslationRequestHandler(
        TranslationConfigInterface $translation
    ): DeeplRequestHandlerInterface
    {
        return new DeeplTranslationRequestHandler($this->authKey, $translation);
    }

    public function createDeeplUsageRequestHandler(): DeeplRequestHandlerInterface
    {
        return new DeeplUsageRequestHandler($this->authKey);
    }

    public function createDeeplFileSubmissionRequestHandler(
        FileTranslationConfigInterface $fileTranslation
    ): DeeplRequestHandlerInterface
    {
        return new DeeplFileSubmissionRequestHandler($this->authKey, $fileTranslation);
    }

    public function createDeeplFileTranslationStatusRequestHandler(
        FileSubmissionInterface $fileSubmission
    ): DeeplRequestHandlerInterface
    {
        return new DeeplFileTranslationStatusRequestHandler($this->authKey, $fileSubmission);
    }

    public function createDeeplFileTranslationRequestHandler(
        FileSubmissionInterface $fileSubmission
    ): DeeplRequestHandlerInterface
    {
        return new DeeplFileRequestHandler($this->authKey, $fileSubmission);
    }
}
