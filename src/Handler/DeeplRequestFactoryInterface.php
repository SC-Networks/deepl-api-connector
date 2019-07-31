<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
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

    public function createDeeplFileSubmissionRequestHandler(
        FileTranslationConfigInterface $fileTranslation
    ): DeeplRequestHandlerInterface;

    public function createDeeplFileTranslationStatusRequestHandler(
        FileSubmissionInterface $fileSubmission
    ): DeeplRequestHandlerInterface;

    public function createDeeplFileTranslationRequestHandler(
        FileSubmissionInterface $fileSubmission
    ): DeeplRequestHandlerInterface;
}
