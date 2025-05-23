<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\GlossaryIdSubmission;
use Scn\DeeplApiConnector\TestCase;

class DeeplGlossaryDeleteRequestHandlerTest extends TestCase
{
    private StreamFactoryInterface&MockObject $streamFactory;

    private GlossaryIdSubmission&MockObject $submission;

    private DeeplGlossaryDeleteRequestHandler $subject;

    protected function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);
        $this->submission = $this->createMock(GlossaryIdSubmission::class);

        $this->subject = new DeeplGlossaryDeleteRequestHandler(
            $this->streamFactory,
            $this->submission,
        );
    }

    #[Test]
    public function getMethod(): void
    {
        self::assertSame(
            DeeplRequestHandlerInterface::METHOD_DELETE,
            $this->subject->getMethod(),
        );
    }

    #[Test]
    public function getPath(): void
    {
        $this->submission->expects(self::once())
            ->method('getId')
            ->with()
            ->willReturn('1');

        self::assertSame(
            '/v2/glossaries/1',
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
            ->with()
            ->willReturn($body);

        self::assertSame(
            $body,
            $this->subject->getBody(),
        );
    }
}
