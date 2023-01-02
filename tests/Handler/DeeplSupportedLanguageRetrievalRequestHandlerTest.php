<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplSupportedLanguageRetrievalRequestHandlerTest extends TestCase
{
    private string $authKey = 'some-auth-key';

    private StreamFactoryInterface $streamFactory;

    private DeeplSupportedLanguageRetrievalRequestHandler $subject;

    protected function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);

        $this->subject = new DeeplSupportedLanguageRetrievalRequestHandler(
            $this->authKey,
            $this->streamFactory
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
        static::assertSame(
            '/v2/languages?type=target',
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

    public function testGetBodyReturnsValue(): void
    {
        $body = $this->createMock(StreamInterface::class);

        $this->streamFactory->expects($this->once())
            ->method('createStream')
            ->with(
                http_build_query(
                    [
                        'auth_key' => $this->authKey,
                    ]
                )
            )
            ->willReturn($body);

        static::assertSame(
            $body,
            $this->subject->getBody()
        );
    }
}
