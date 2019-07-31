<?php

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplFileSubmissionRequestHandlerTest extends TestCase
{
    /**
     * @var DeeplFileRequestHandler
     */
    private $subject;

    /**
     * @var FileTranslationConfigInterface|MockObject
     */
    private $fileTranslation;

    public function setUp(): void
    {
        $this->fileTranslation = $this->createMock(FileTranslationConfigInterface::class);

        $this->subject = new DeeplFileSubmissionRequestHandler(
            'some key',
            $this->fileTranslation
        );
    }

    public function testGetPathCanReturnPath()
    {
        $this->assertSame(DeeplFileSubmissionRequestHandler::API_ENDPOINT, $this->subject->getPath());
    }

    public function testGetBodyCanReturnFilteredArray()
    {
        $this->fileTranslation->expects($this->exactly(2))
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

        $this->assertSame(
            [
                'multipart' =>
                    [
                        [
                            'name' => 'auth_key',
                            'contents' => 'some key'
                        ],
                        [
                            'name' => 'file',
                            'filename' => 'file name',
                            'contents' => 'file content'
                        ],
                        [
                            'name' => 'filename',
                            'contents' => 'file name'
                        ],
                        [
                            'name' => 'source_lang',
                            'contents' => 'source lang'
                        ],
                        [
                            'name' => 'target_lang',
                            'contents' => 'target lang'
                        ],
                    ]
            ],
            $this->subject->getBody()
        );
    }

    public function testGetMethodCanReturnMethod()
    {
        $this->assertSame(DeeplRequestHandlerInterface::METHOD_POST, $this->subject->getMethod());
    }
}
