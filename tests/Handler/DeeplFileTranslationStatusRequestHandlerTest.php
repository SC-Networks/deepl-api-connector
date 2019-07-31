<?php

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplFileTranslationStatusRequestHandlerTest extends TestCase
{
    /**
     * @var DeeplFileTranslationStatusRequestHandler
     */
    private $subject;

    /**
     * @var FileSubmissionInterface|MockObject
     */
    private $fileSubmission;

    public function setUp(): void
    {
        $this->fileSubmission = $this->createMock(FileSubmissionInterface::class);

        $this->subject = new DeeplFileTranslationStatusRequestHandler(
            'some key',
            $this->fileSubmission
        );
    }

    public function testGetPathCanReturnPath()
    {
        $this->fileSubmission->expects($this->once())
            ->method('getDocumentId')
            ->willReturn('documentId');
        $this->assertSame(sprintf(DeeplFileTranslationStatusRequestHandler::API_ENDPOINT, 'documentId'), $this->subject->getPath());
    }

    public function testGetBodyCanReturnFilteredArray()
    {
        $this->fileSubmission->expects($this->once())
            ->method('getDocumentKey')
            ->willReturn('document key');

        $this->assertSame(
            [
                'form_params' =>
                    [
                        'auth_key' => 'some key',
                        'document_key' => 'document key'
                    ]
            ],
            $this->subject->getBody()
        );
    }

    public function testGetMethodCanReturnMethod()
    {
        $this->assertSame(DeeplRequestHandlerInterface::METHOD_GET, $this->subject->getMethod());
    }
}
