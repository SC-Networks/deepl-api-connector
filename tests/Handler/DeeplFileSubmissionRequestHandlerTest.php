<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplFileSubmissionRequestHandlerTest extends TestCase
{
    /**
     * @var DeeplFileRequestHandler
     */
    private $subject;

    /** @var MultipartStreamBuilder|MockObject */
    private $streamBuilder;

    /**
     * @var FileTranslationConfigInterface|MockObject
     */
    private $fileTranslation;

    public function setUp(): void
    {
        $this->streamBuilder = $this->createMock(MultipartStreamBuilder::class);
        $this->fileTranslation = $this->createMock(FileTranslationConfigInterface::class);

        $this->subject = new DeeplFileSubmissionRequestHandler(
            'some key',
            $this->fileTranslation,
            $this->streamBuilder
        );
    }

    public function testGetPathCanReturnPath(): void
    {
        $this->assertSame(DeeplFileSubmissionRequestHandler::API_ENDPOINT, $this->subject->getPath());
    }

    public function testGetBodyCanReturnFilteredArray(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $this->fileTranslation->expects($this->once())
            ->method('getFileName')
            ->willReturn('file name');

        $this->fileTranslation->expects($this->once())
            ->method('getFileContent')
            ->willReturn('file content');

        $this->fileTranslation->expects($this->once())
            ->method('getSourceLang')
            ->willReturn('source lang');

        $this->fileTranslation->expects($this->once())
            ->method('getTargetLang')
            ->willReturn('target lang');

        $this->streamBuilder->expects($this->once())
            ->method('setBoundary')
            ->with('boundary')
            ->willReturn($this->streamBuilder);
        $this->streamBuilder->expects($this->exactly(4))
            ->method('addResource')
            ->withConsecutive(
                ['auth_key', 'some key'],
                ['file', 'file content', ['filename' => 'file name']],
                ['source_lang', 'source lang'],
                ['target_lang', 'target lang']
            )
            ->willReturnSelf();
        $this->streamBuilder->expects($this->once())
            ->method('build')
            ->willReturn($stream);

        $this->assertSame(
            $stream,
            $this->subject->getBody()
        );
    }

    public function testGetMethodCanReturnMethod(): void
    {
        $this->assertSame(DeeplRequestHandlerInterface::METHOD_POST, $this->subject->getMethod());
    }

    public function testGetContentTypeReturnsValue(): void
    {
        $this->assertSame(
            'multipart/form-data;boundary="boundary"',
            $this->subject->getContentType()
        );
    }
}
