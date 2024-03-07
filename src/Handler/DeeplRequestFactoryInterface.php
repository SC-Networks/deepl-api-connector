<?php

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\BatchTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\GlossaryIdSubmissionInterface;
use Scn\DeeplApiConnector\Model\GlossarySubmissionInterface;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

interface DeeplRequestFactoryInterface
{
    public function createDeeplTranslationRequestHandler(
        TranslationConfigInterface $translation
    ): DeeplRequestHandlerInterface;

    public function createDeeplBatchTranslationRequestHandler(
        BatchTranslationConfigInterface $translation
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

    public function createDeeplSupportedLanguageRetrievalRequestHandler(): DeeplRequestHandlerInterface;

    public function createDeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler(): DeeplRequestHandlerInterface;

    public function createDeeplGlossariesListRetrievalRequestHandler(): DeeplRequestHandlerInterface;

    public function createDeeplGlossaryCreateRequestHandler(
        GlossarySubmissionInterface $submission
    ): DeeplRequestHandlerInterface;

    public function createDeeplGlossaryRetrieveRequestHandler(
        GlossaryIdSubmissionInterface $submission
    ): DeeplRequestHandlerInterface;

    public function createDeeplGlossaryDeleteRequestHandler(
        GlossaryIdSubmissionInterface $submission
    ): DeeplRequestHandlerInterface;

    public function createDeeplGlossaryEntriesRetrieveRequestHandler(
        GlossaryIdSubmissionInterface $submission
    ): DeeplRequestHandlerInterface;

    public function getDeeplBaseUri(): string;
}
