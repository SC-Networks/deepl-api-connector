<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

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

    /** @var StreamFactoryInterface|MockObject */
    private $streamFactory;

    protected function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);

        $this->subject = new DeeplRequestFactory(
            'some api key',
            $this->streamFactory
        );
    }

    public function testCreateDeeplUsageRequestHandlerCanReturnInstanceOfUsageRequestHandler(): void
    {
        self::assertInstanceOf(DeeplUsageRequestHandler::class, $this->subject->createDeeplUsageRequestHandler());
    }

    public function testCreateDeeplTranslationRequestHandler(): void
    {
        $translation = $this->createMock(TranslationConfigInterface::class);
        self::assertInstanceOf(DeeplTranslationRequestHandler::class, $this->subject->createDeeplTranslationRequestHandler($translation));
    }

    public function testCreateDeeplBatchTranslationRequestHandler(): void
    {
        $translation = $this->createMock(BatchTranslationConfigInterface::class);

        self::assertInstanceOf(DeeplBatchTranslationRequestHandler::class, $this->subject->createDeeplBatchTranslationRequestHandler($translation));
    }

    public function testCreateDeeplFileSubmissionRequestHandler(): void
    {
        $fileTranslation = $this->createMock(FileTranslationConfigInterface::class);
        self::assertInstanceOf(DeeplFileSubmissionRequestHandler::class, $this->subject->createDeeplFileSubmissionRequestHandler($fileTranslation));
    }

    public function testCreateDeeplFileTranslationStatusRequestHandler(): void
    {
        $fileSubmission = $this->createMock(FileSubmissionInterface::class);
        self::assertInstanceOf(DeeplFileTranslationStatusRequestHandler::class, $this->subject->createDeeplFileTranslationStatusRequestHandler($fileSubmission));
    }

    public function testCreateDeeplFileTranslationRequestHandler(): void
    {
        $fileSubmission = $this->createMock(FileSubmissionInterface::class);
        self::assertInstanceOf(DeeplFileRequestHandler::class, $this->subject->createDeeplFileTranslationRequestHandler($fileSubmission));
    }

    public function testCreateDeeplSupportedLanguageRetrievalRequestHandler(): void
    {
        self::assertInstanceOf(DeeplSupportedLanguageRetrievalRequestHandler::class, $this->subject->createDeeplSupportedLanguageRetrievalRequestHandler());
    }

    public function testGetDeeplBaseUriCanReturnPaidBaseUri(): void
    {
        self::assertSame(DeeplRequestFactory::DEEPL_PAID_BASE_URI, $this->subject->getDeeplBaseUri());
    }

    public function testGetDeeplFreeUriCanReturnFreeBaseUri(): void
    {
        $this->subject = new DeeplRequestFactory('something:fx', $this->streamFactory);
        self::assertSame(DeeplRequestFactory::DEEPL_FREE_BASE_URI, $this->subject->getDeeplBaseUri());
    }

    public function testCreateDeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler(): void
    {
        self::assertInstanceOf(DeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler::class, $this->subject->createDeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler());
    }

    public function testCreateDeeplGlossariesListRetrievalRequestHandler(): void
    {
        self::assertInstanceOf(DeeplGlossariesListRetrievalRequestHandler::class, $this->subject->createDeeplGlossariesListRetrievalRequestHandler());
    }

    public function testCreateDeeplGlossaryCreateRequestHandler(): void
    {
        $submission = $this->createMock(GlossarySubmission::class);

        self::assertInstanceOf(DeeplGlossaryCreateRequestHandler::class, $this->subject->createDeeplGlossaryCreateRequestHandler($submission));
    }

    public function testCreateDeeplGlossaryRetrieveRequestHandler(): void
    {
        $submission = $this->createMock(GlossaryIdSubmission::class);

        self::assertInstanceOf(DeeplGlossaryRetrieveRequestHandler::class, $this->subject->createDeeplGlossaryRetrieveRequestHandler($submission));
    }

    public function testCreateDeeplGlossaryDeleteRequestHandler(): void
    {
        $submission = $this->createMock(GlossaryIdSubmission::class);

        self::assertInstanceOf(DeeplGlossaryDeleteRequestHandler::class, $this->subject->createDeeplGlossaryDeleteRequestHandler($submission));
    }

    public function testCreateDeeplGlossaryEntriesRetrieveRequestHandler(): void
    {
        $submission = $this->createMock(GlossaryIdSubmission::class);

        self::assertInstanceOf(DeeplGlossaryEntriesRetrieveRequestHandler::class, $this->subject->createDeeplGlossaryEntriesRetrieveRequestHandler($submission));
    }
    //TODO tests
}
