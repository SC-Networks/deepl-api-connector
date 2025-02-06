<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\GlossarySubmission;
use Scn\DeeplApiConnector\TestCase;

class DeeplGlossaryCreateRequestHandlerTest extends TestCase
{
    private StreamFactoryInterface&MockObject $streamFactory;

    private GlossarySubmission&MockObject $submission;

    private DeeplGlossaryCreateRequestHandler $subject;

    protected function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);
        $this->submission = $this->createMock(GlossarySubmission::class);

        $this->subject = new DeeplGlossaryCreateRequestHandler(
            $this->streamFactory,
            $this->submission,
        );
    }

    #[Test]
    public function getMethod(): void
    {
        self::assertSame(
            DeeplRequestHandlerInterface::METHOD_POST,
            $this->subject->getMethod(),
        );
    }

    #[Test]
    public function getPath(): void
    {
        self::assertSame(
            '/v2/glossaries',
            $this->subject->getPath(),
        );
    }

    #[Test]
    public function getContentType(): void
    {
        self::assertSame(
            'application/json',
            $this->subject->getContentType(),
        );
    }

    #[Test]
    public function getBody(): void
    {
        $body = $this->createMock(StreamInterface::class);

        $this->submission->expects(self::once())
            ->method('toArrayRequest')
            ->willReturn(['test' => 'test1']);

        $this->streamFactory->expects(self::once())
            ->method('createStream')
            ->with()
            ->willReturn($body);

        self::assertSame(
            $body,
            $this->subject->getBody(),
        );
    }
}
