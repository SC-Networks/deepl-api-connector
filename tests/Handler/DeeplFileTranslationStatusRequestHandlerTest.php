<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplFileTranslationStatusRequestHandlerTest extends TestCase
{
    private DeeplFileTranslationStatusRequestHandler $subject;

    private StreamFactoryInterface&MockObject $streamFactory;

    private FileSubmissionInterface&MockObject $fileSubmission;

    public function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);
        $this->fileSubmission = $this->createMock(FileSubmissionInterface::class);

        $this->subject = new DeeplFileTranslationStatusRequestHandler(
            $this->streamFactory,
            $this->fileSubmission,
        );
    }

    #[Test]
    public function testGetPathCanReturnPath(): void
    {
        $this->fileSubmission->expects(self::once())
            ->method('getDocumentId')
            ->willReturn('documentId');
        self::assertSame(sprintf(DeeplFileTranslationStatusRequestHandler::API_ENDPOINT, 'documentId'), $this->subject->getPath());
    }

    #[Test]
    public function getBody(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $this->fileSubmission->expects(self::once())
            ->method('getDocumentKey')
            ->willReturn('document key');

        $this->streamFactory->expects(self::once())
            ->method('createStream')
            ->with(
                json_encode(['document_key' => 'document key']),
            )
            ->willReturn($stream);

        self::assertSame($stream, $this->subject->getBody());
    }

    #[Test]
    public function getMethod(): void
    {
        self::assertSame(DeeplRequestHandlerInterface::METHOD_POST, $this->subject->getMethod());
    }

    #[Test]
    public function getContentType(): void
    {
        self::assertSame('application/json', $this->subject->getContentType());
    }
}
