<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplFileRequestHandlerTest extends TestCase
{
    /**
     * @var DeeplFileRequestHandler
     */
    private $subject;

    /** @var StreamFactoryInterface|MockObject */
    private $streamFactory;

    /**
     * @var FileSubmissionInterface|MockObject
     */
    private $fileSubmission;

    public function setUp(): void
    {
        $this->fileSubmission = $this->createMock(FileSubmissionInterface::class);
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);

        $this->subject = new DeeplFileRequestHandler(
            'some key',
            $this->streamFactory,
            $this->fileSubmission
        );
    }

    public function testGetPathCanReturnPath(): void
    {
        $this->fileSubmission->expects($this->once())
            ->method('getDocumentId')
            ->willReturn('documentId');
        self::assertSame(sprintf(DeeplFileRequestHandler::API_ENDPOINT, 'documentId'), $this->subject->getPath());
    }

    public function testGetBodyCanReturnFilteredArray(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $this->fileSubmission->expects($this->once())
            ->method('getDocumentKey')
            ->willReturn('document key');

        $this->streamFactory->expects($this->once())
            ->method('createStream')
            ->with(
                http_build_query(
                    [
                        'auth_key' => 'some key',
                        'document_key' => 'document key',
                    ]
                )
            )
            ->willReturn($stream);

        self::assertSame($stream, $this->subject->getBody());
    }

    public function testGetMethodCanReturnMethod(): void
    {
        self::assertSame(DeeplRequestHandlerInterface::METHOD_POST, $this->subject->getMethod());
    }

    public function testGetContentTypeReturnsValue(): void
    {
        self::assertSame('application/x-www-form-urlencoded', $this->subject->getContentType());
    }
}
