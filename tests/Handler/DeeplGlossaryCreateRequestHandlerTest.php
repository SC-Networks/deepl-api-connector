<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\GlossarySubmission;
use Scn\DeeplApiConnector\TestCase;

class DeeplGlossaryCreateRequestHandlerTest extends TestCase
{
    private string $authKey = 'some-auth-key';

    private StreamFactoryInterface $streamFactory;

    private DeeplGlossaryCreateRequestHandler $subject;

    private GlossarySubmission $submission;

    protected function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);
        $this->submission = $this->createMock(GlossarySubmission::class);

        $this->subject = new DeeplGlossaryCreateRequestHandler(
            $this->authKey,
            $this->streamFactory,
            $this->submission,
        );
    }

    public function testGetMethodReturnsValue(): void
    {
        static::assertSame(
            DeeplRequestHandlerInterface::METHOD_POST,
            $this->subject->getMethod()
        );
    }

    public function testGetPathReturnsValue(): void
    {
        static::assertSame(
            '/v2/glossaries',
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

    public function testGetBodyReturnsValue(): void
    {
        $body = $this->createMock(StreamInterface::class);

        $this->submission->expects($this->once())
            ->method('toArrayRequest')
            ->willReturn([
                'test' => 'test1',
            ]);

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
