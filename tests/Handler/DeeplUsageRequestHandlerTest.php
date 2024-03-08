<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplUsageRequestHandlerTest extends TestCase
{
    /**
     * @var DeeplUsageRequestHandler
     */
    private $subject;

    /** @var StreamFactoryInterface|MockObject */
    private $streamFactory;

    public function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);

        $this->subject = new DeeplUsageRequestHandler(
            'some key',
            $this->streamFactory
        );
    }

    public function testGetPathCanReturnApiPath(): void
    {
        self::assertSame(DeeplUsageRequestHandler::API_ENDPOINT, $this->subject->getPath());
    }

    public function testGetMethodCanReturnMethod(): void
    {
        self::assertSame(DeeplRequestHandlerInterface::METHOD_GET, $this->subject->getMethod());
    }

    public function testGetBodyCanReturnArray(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $this->streamFactory->expects($this->once())
            ->method('createStream')
            ->with(
                http_build_query(['auth_key' => 'some key'])
            )
            ->willReturn($stream);

        self::assertSame($stream, $this->subject->getBody());
    }

    public function testGetContentTypeReturnsValue(): void
    {
        self::assertSame('application/x-www-form-urlencoded', $this->subject->getContentType());
    }
}
