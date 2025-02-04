<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Message\StreamFactoryInterface;
use Scn\DeeplApiConnector\Model\BatchTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\GlossaryIdSubmissionInterface;
use Scn\DeeplApiConnector\Model\GlossarySubmissionInterface;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

final class DeeplRequestFactory implements DeeplRequestFactoryInterface
{
    private StreamFactoryInterface $streamFactory;

    public function __construct(
        StreamFactoryInterface $streamFactory,
    ) {
        $this->streamFactory = $streamFactory;
    }

    public function createDeeplTranslationRequestHandler(
        TranslationConfigInterface $translation,
    ): DeeplRequestHandlerInterface {
        return new DeeplTranslationRequestHandler(
            $this->streamFactory,
            $translation,
        );
    }

    public function createDeeplBatchTranslationRequestHandler(
        BatchTranslationConfigInterface $translation,
    ): DeeplRequestHandlerInterface {
        return new DeeplBatchTranslationRequestHandler(
            $this->streamFactory,
            $translation,
        );
    }

    public function createDeeplUsageRequestHandler(): DeeplRequestHandlerInterface
    {
        return new DeeplUsageRequestHandler(
            $this->streamFactory,
        );
    }

    public function createDeeplFileSubmissionRequestHandler(
        FileTranslationConfigInterface $fileTranslation
    ): DeeplRequestHandlerInterface {
        return new DeeplFileSubmissionRequestHandler(
            $fileTranslation,
            new MultipartStreamBuilder(
                $this->streamFactory,
            ),
        );
    }

    public function createDeeplFileTranslationStatusRequestHandler(
        FileSubmissionInterface $fileSubmission
    ): DeeplRequestHandlerInterface {
        return new DeeplFileTranslationStatusRequestHandler(
            $this->streamFactory,
            $fileSubmission,
        );
    }

    public function createDeeplFileTranslationRequestHandler(
        FileSubmissionInterface $fileSubmission
    ): DeeplRequestHandlerInterface {
        return new DeeplFileRequestHandler(
            $this->streamFactory,
            $fileSubmission,
        );
    }

    public function createDeeplSupportedLanguageRetrievalRequestHandler(): DeeplRequestHandlerInterface
    {
        return new DeeplSupportedLanguageRetrievalRequestHandler(
            $this->streamFactory,
        );
    }

    public function createDeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler(): DeeplRequestHandlerInterface
    {
        return new DeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler(
            $this->streamFactory,
        );
    }

    public function createDeeplGlossariesListRetrievalRequestHandler(): DeeplRequestHandlerInterface
    {
        return new DeeplGlossariesListRetrievalRequestHandler(
            $this->streamFactory,
        );
    }

    public function createDeeplGlossaryCreateRequestHandler(
        GlossarySubmissionInterface $submission
    ): DeeplRequestHandlerInterface {
        return new DeeplGlossaryCreateRequestHandler(
            $this->streamFactory,
            $submission,
        );
    }

    public function createDeeplGlossaryRetrieveRequestHandler(
        GlossaryIdSubmissionInterface $submission
    ): DeeplRequestHandlerInterface {
        return new DeeplGlossaryRetrieveRequestHandler(
            $this->streamFactory,
            $submission,
        );
    }

    public function createDeeplGlossaryDeleteRequestHandler(
        GlossaryIdSubmissionInterface $submission,
    ): DeeplRequestHandlerInterface {
        return new DeeplGlossaryDeleteRequestHandler(
            $this->streamFactory,
            $submission,
        );
    }

    public function createDeeplGlossaryEntriesRetrieveRequestHandler(
        GlossaryIdSubmissionInterface $submission,
    ): DeeplRequestHandlerInterface {
        return new DeeplGlossaryEntriesRetrieveRequestHandler(
            $this->streamFactory,
            $submission,
        );
    }
}
