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
    public const DEEPL_PAID_BASE_URI = 'https://api.deepl.com';
    public const DEEPL_FREE_BASE_URI = 'https://api-free.deepl.com';

    private string $authKey;

    private StreamFactoryInterface $streamFactory;

    public function __construct(
        string $authKey,
        StreamFactoryInterface $streamFactory
    ) {
        $this->authKey = $authKey;
        $this->streamFactory = $streamFactory;
    }

    public function createDeeplTranslationRequestHandler(
        TranslationConfigInterface $translation
    ): DeeplRequestHandlerInterface {
        return new DeeplTranslationRequestHandler(
            $this->authKey,
            $this->streamFactory,
            $translation
        );
    }

    public function createDeeplBatchTranslationRequestHandler(
        BatchTranslationConfigInterface $translation
    ): DeeplRequestHandlerInterface {
        return new DeeplBatchTranslationRequestHandler(
            $this->authKey,
            $this->streamFactory,
            $translation
        );
    }

    public function createDeeplUsageRequestHandler(): DeeplRequestHandlerInterface
    {
        return new DeeplUsageRequestHandler(
            $this->authKey,
            $this->streamFactory
        );
    }

    public function createDeeplFileSubmissionRequestHandler(
        FileTranslationConfigInterface $fileTranslation
    ): DeeplRequestHandlerInterface {
        return new DeeplFileSubmissionRequestHandler(
            $this->authKey,
            $fileTranslation,
            new MultipartStreamBuilder(
                $this->streamFactory
            )
        );
    }

    public function createDeeplFileTranslationStatusRequestHandler(
        FileSubmissionInterface $fileSubmission
    ): DeeplRequestHandlerInterface {
        return new DeeplFileTranslationStatusRequestHandler(
            $this->authKey,
            $this->streamFactory,
            $fileSubmission
        );
    }

    public function createDeeplFileTranslationRequestHandler(
        FileSubmissionInterface $fileSubmission
    ): DeeplRequestHandlerInterface {
        return new DeeplFileRequestHandler(
            $this->authKey,
            $this->streamFactory,
            $fileSubmission
        );
    }

    public function createDeeplSupportedLanguageRetrievalRequestHandler(): DeeplRequestHandlerInterface
    {
        return new DeeplSupportedLanguageRetrievalRequestHandler(
            $this->authKey,
            $this->streamFactory
        );
    }

    public function createDeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler(): DeeplRequestHandlerInterface
    {
        return new DeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler(
            $this->authKey,
            $this->streamFactory
        );
    }

    public function createDeeplGlossariesListRetrievalRequestHandler(): DeeplRequestHandlerInterface
    {
        return new DeeplGlossariesListRetrievalRequestHandler(
            $this->authKey,
            $this->streamFactory
        );
    }

    public function createDeeplGlossaryCreateRequestHandler(
        GlossarySubmissionInterface $submission
    ): DeeplRequestHandlerInterface {
        return new DeeplGlossaryCreateRequestHandler(
            $this->authKey,
            $this->streamFactory,
            $submission
        );
    }

    public function createDeeplGlossaryRetrieveRequestHandler(
        GlossaryIdSubmissionInterface $submission
    ): DeeplRequestHandlerInterface {
        return new DeeplGlossaryRetrieveRequestHandler(
            $this->authKey,
            $this->streamFactory,
            $submission
        );
    }

    public function createDeeplGlossaryDeleteRequestHandler(
        GlossaryIdSubmissionInterface $submission
    ): DeeplRequestHandlerInterface {
        return new DeeplGlossaryDeleteRequestHandler(
            $this->authKey,
            $this->streamFactory,
            $submission
        );
    }

    public function createDeeplGlossaryEntriesRetrieveRequestHandler(
        GlossaryIdSubmissionInterface $submission
    ): DeeplRequestHandlerInterface {
        return new DeeplGlossaryEntriesRetrieveRequestHandler(
            $this->authKey,
            $this->streamFactory,
            $submission
        );
    }

    public function getDeeplBaseUri(): string
    {
        if (strpos($this->authKey, ':fx') !== false) {
            return DeeplRequestFactory::DEEPL_FREE_BASE_URI;
        }

        return DeeplRequestFactory::DEEPL_PAID_BASE_URI;
    }
}
