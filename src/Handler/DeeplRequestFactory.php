<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Message\StreamFactoryInterface;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

final class DeeplRequestFactory implements DeeplRequestFactoryInterface
{
    private $authKey;

    private $streamFactory;

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
}
