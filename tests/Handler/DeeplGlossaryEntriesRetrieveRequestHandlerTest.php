<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\GlossaryIdSubmission;
use Scn\DeeplApiConnector\TestCase;

class DeeplGlossaryEntriesRetrieveRequestHandlerTest extends TestCase
{
    private string $authKey = 'some-auth-key';

    private StreamFactoryInterface $streamFactory;

    private DeeplGlossaryEntriesRetrieveRequestHandler $subject;

    private GlossaryIdSubmission $submission;

    protected function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);
        $this->submission = $this->createMock(GlossaryIdSubmission::class);

        $this->subject = new DeeplGlossaryEntriesRetrieveRequestHandler(
            $this->authKey,
            $this->streamFactory,
            $this->submission,
        );
    }

    public function testGetMethodReturnsValue(): void
    {
        static::assertSame(
            DeeplRequestHandlerInterface::METHOD_GET,
            $this->subject->getMethod()
        );
    }

    public function testGetPathReturnsValue(): void
    {
        $this->submission->expects($this->once())
            ->method('getId')
            ->with()
            ->willReturn('1');

        static::assertSame(
            '/v2/glossaries/1/entries',
            $this->subject->getPath()
        );
    }

    public function testGetContentTypeReturnsValue(): void
    {
        static::assertSame(
            'application/x-www-form-urlencoded',
            $this->subject->getContentType()
        );
    }

    public function testGetAuthHeader(): void
    {
        static::assertSame(
            'DeepL-Auth-Key some-auth-key',
            $this->subject->getAuthHeader()
        );
    }

    public function testGetAcceptHeader(): void
    {
        static::assertSame(
            'text/tab-separated-values',
            $this->subject->getAcceptHeader()
        );
    }

    public function testGetBodyReturnsValue(): void
    {
        $body = $this->createMock(StreamInterface::class);

        $this->streamFactory->expects($this->once())
            ->method('createStream')
            ->with()
            ->willReturn($body);

        static::assertSame(
            $body,
            $this->subject->getBody()
        );
    }
}
