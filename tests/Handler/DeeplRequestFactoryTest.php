<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Scn\DeeplApiConnector\Model\BatchTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\GlossaryIdSubmission;
use Scn\DeeplApiConnector\Model\GlossarySubmission;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplRequestFactoryTest extends TestCase
{
    private DeeplRequestFactory  $subject;

    private StreamFactoryInterface&MockObject $streamFactory;

    protected function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);

        $this->subject = new DeeplRequestFactory(
            $this->streamFactory,
        );
    }

    #[Test]
    public function createDeeplUsageRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplUsageRequestHandler::class,
            $this->subject->createDeeplUsageRequestHandler(),
        );
    }

    #[Test]
    public function createDeeplTranslationRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplTranslationRequestHandler::class,
            $this->subject->createDeeplTranslationRequestHandler(
                $this->createMock(TranslationConfigInterface::class),
            ),
        );
    }

    #[Test]
    public function createDeeplBatchTranslationRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplBatchTranslationRequestHandler::class,
            $this->subject->createDeeplBatchTranslationRequestHandler(
                $this->createMock(BatchTranslationConfigInterface::class),
            ),
        );
    }

    #[Test]
    public function createDeeplFileSubmissionRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplFileSubmissionRequestHandler::class,
            $this->subject->createDeeplFileSubmissionRequestHandler(
                $this->createMock(FileTranslationConfigInterface::class),
            ),
        );
    }

    #[Test]
    public function createDeeplFileTranslationStatusRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplFileTranslationStatusRequestHandler::class,
            $this->subject->createDeeplFileTranslationStatusRequestHandler(
                $this->createMock(FileSubmissionInterface::class),
            ),
        );
    }

    #[Test]
    public function createDeeplFileTranslationRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplFileRequestHandler::class,
            $this->subject->createDeeplFileTranslationRequestHandler(
                $this->createMock(FileSubmissionInterface::class),
            ),
        );
    }

    #[Test]
    public function createDeeplSupportedLanguageRetrievalRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplSupportedLanguageRetrievalRequestHandler::class,
            $this->subject->createDeeplSupportedLanguageRetrievalRequestHandler(),
        );
    }

    #[Test]
    public function createDeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler::class,
            $this->subject->createDeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler(),
        );
    }

    #[Test]
    public function createDeeplGlossariesListRetrievalRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplGlossariesListRetrievalRequestHandler::class,
            $this->subject->createDeeplGlossariesListRetrievalRequestHandler(),
        );
    }

    public function testCreateDeeplGlossaryCreateRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplGlossaryCreateRequestHandler::class,
            $this->subject->createDeeplGlossaryCreateRequestHandler(
                $this->createMock(GlossarySubmission::class),
            ),
        );
    }

    #[Test]
    public function createDeeplGlossaryRetrieveRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplGlossaryRetrieveRequestHandler::class,
            $this->subject->createDeeplGlossaryRetrieveRequestHandler(
                $this->createMock(GlossaryIdSubmission::class),
            ),
        );
    }

    #[Test]
    public function createDeeplGlossaryDeleteRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplGlossaryDeleteRequestHandler::class,
            $this->subject->createDeeplGlossaryDeleteRequestHandler(
                $this->createMock(GlossaryIdSubmission::class),
            ),
        );
    }

    public function testCreateDeeplGlossaryEntriesRetrieveRequestHandler(): void
    {
        self::assertInstanceOf(
            DeeplGlossaryEntriesRetrieveRequestHandler::class,
            $this->subject->createDeeplGlossaryEntriesRetrieveRequestHandler(
                $this->createMock(GlossaryIdSubmission::class),
            )
        );
    }
}
