<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplSupportedLanguageRetrievalRequestHandlerTest extends TestCase
{
    private StreamFactoryInterface&MockObject $streamFactory;

    private DeeplSupportedLanguageRetrievalRequestHandler $subject;

    protected function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);

        $this->subject = new DeeplSupportedLanguageRetrievalRequestHandler(
            $this->streamFactory,
        );
    }

    #[Test]
    public function getMethod(): void
    {
        self::assertSame(
            DeeplRequestHandlerInterface::METHOD_GET,
            $this->subject->getMethod(),
        );
    }

    #[Test]
    public function getPath(): void
    {
        self::assertSame(
            '/v2/languages?type=target',
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

        $this->streamFactory->expects(self::once())
            ->method('createStream')
            ->willReturn($body);

        self::assertSame(
            $body,
            $this->subject->getBody(),
        );
    }
}
