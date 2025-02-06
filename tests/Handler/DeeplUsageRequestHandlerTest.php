<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplUsageRequestHandlerTest extends TestCase
{
    private DeeplUsageRequestHandler $subject;

    private StreamFactoryInterface&MockObject $streamFactory;

    public function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);

        $this->subject = new DeeplUsageRequestHandler(
            $this->streamFactory,
        );
    }

    #[Test]
    public function getPath(): void
    {
        self::assertSame(DeeplUsageRequestHandler::API_ENDPOINT, $this->subject->getPath());
    }

    #[Test]
    public function getMethod(): void
    {
        self::assertSame(DeeplRequestHandlerInterface::METHOD_GET, $this->subject->getMethod());
    }

    #[Test]
    public function getBody(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $this->streamFactory->expects(self::once())
            ->method('createStream')
            ->willReturn($stream);

        self::assertSame($stream, $this->subject->getBody());
    }

    #[Test]
    public function getContentType(): void
    {
        self::assertSame('application/json', $this->subject->getContentType());
    }
}
