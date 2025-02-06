<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplFileSubmissionRequestHandlerTest extends TestCase
{
    private DeeplFileSubmissionRequestHandler $subject;

    private MultipartStreamBuilder&MockObject $streamBuilder;

    private FileTranslationConfigInterface&MockObject $fileTranslation;

    public function setUp(): void
    {
        $this->fileTranslation = $this->createMock(FileTranslationConfigInterface::class);
        $this->streamBuilder = $this->createMock(MultipartStreamBuilder::class);

        $this->subject = new DeeplFileSubmissionRequestHandler(
            $this->fileTranslation,
            $this->streamBuilder,
        );
    }

    #[Test]
    public function getPath(): void
    {
        self::assertSame(DeeplFileSubmissionRequestHandler::API_ENDPOINT, $this->subject->getPath());
    }

    #[Test]
    public function getBodyFiltered(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $this->fileTranslation->expects(self::once())
            ->method('getFileName')
            ->willReturn('file name');

        $this->fileTranslation->expects(self::once())
            ->method('getFileContent')
            ->willReturn('file content');

        $this->fileTranslation->expects(self::once())
            ->method('getSourceLang')
            ->willReturn('source lang');

        $this->fileTranslation->expects(self::once())
            ->method('getTargetLang')
            ->willReturn('target lang');

        $this->streamBuilder->expects(self::once())
            ->method('setBoundary')
            ->with('boundary')
            ->willReturnSelf();

        $this->streamBuilder->expects(self::exactly(3))
            ->method('addResource')
            ->willReturnOnConsecutiveCalls(
                ['file', 'file content', ['filename' => 'file name']],
                ['target_lang', 'target lang'],
                ['source_lang', 'source lang'],
            )
            ->willReturnSelf();
        $this->streamBuilder->expects(self::once())
            ->method('build')
            ->willReturn($stream);

        self::assertSame($stream, $this->subject->getBody());
    }

    #[Test]
    public function getBodyOnIgnoresSourceLangIfEmpty(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $this->fileTranslation->expects(self::once())
            ->method('getFileName')
            ->willReturn('file name');

        $this->fileTranslation->expects(self::once())
            ->method('getFileContent')
            ->willReturn('file content');

        $this->fileTranslation->expects(self::once())
            ->method('getSourceLang')
            ->willReturn('');

        $this->fileTranslation->expects(self::once())
            ->method('getTargetLang')
            ->willReturn('target lang');

        $this->streamBuilder->expects(self::once())
            ->method('setBoundary')
            ->with('boundary')
            ->willReturnSelf();
        $this->streamBuilder->expects(self::exactly(2))
            ->method('addResource')
            ->willReturnOnConsecutiveCalls(
                ['file', 'file content', ['filename' => 'file name']],
                ['target_lang', 'target lang'],
            )
            ->willReturnSelf();
        $this->streamBuilder->expects(self::once())
            ->method('build')
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
        self::assertSame('multipart/form-data;boundary="boundary"', $this->subject->getContentType());
    }
}
