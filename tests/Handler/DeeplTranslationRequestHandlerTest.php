<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Enum\TextHandlingEnum;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplTranslationRequestHandlerTest extends TestCase
{
    private DeeplTranslationRequestHandler $subject;

    private StreamFactoryInterface&MockObject $streamFactory;

    private TranslationConfigInterface&MockObject $translation;

    public function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);
        $this->translation = $this->createMock(TranslationConfigInterface::class);

        $this->subject = new DeeplTranslationRequestHandler(
            $this->streamFactory,
            $this->translation,
        );
    }

    #[Test]
    public function getPath(): void
    {
        self::assertSame(DeeplTranslationRequestHandler::API_ENDPOINT, $this->subject->getPath());
    }

    #[Test]
    public function getBodyFiltered(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $this->translation->expects(self::once())
            ->method('getText')
            ->willReturn('some text to translate');

        $this->translation->expects(self::once())
            ->method('getTargetLang')
            ->willReturn('DE');

        $this->streamFactory->expects(self::once())
            ->method('createStream')
            ->with(
                json_encode(
                    [
                        'text' => ['some text to translate'],
                        'target_lang' => 'DE',
                    ],
                )
            )
            ->willReturn($stream);

        self::assertSame($stream, $this->subject->getBody());
    }

    #[Test]
    public function getBodyWithOptionalTags(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $this->translation->expects(self::once())
            ->method('getText')
            ->willReturn('some text to translate');

        $this->translation->expects(self::once())
            ->method('getTargetLang')
            ->willReturn('DE');

        $this->translation->expects(self::once())
            ->method('getSourceLang')
            ->willReturn('EN');

        $this->translation->expects(self::once())
            ->method('getTagHandling')
            ->willReturn(['a', 'b']);

        $this->translation->expects(self::once())
            ->method('getNonSplittingTags')
            ->willReturn(['b', 'a', 'c']);

        $this->translation->expects(self::once())
            ->method('getIgnoreTags')
            ->willReturn(['ef', 'fa', 'qa']);

        $this->translation->expects(self::once())
            ->method('getSplitSentences')
            ->willReturn(TextHandlingEnum::SPLITSENTENCES_ON);

        $this->translation->expects(self::once())
            ->method('getPreserveFormatting')
            ->willReturn(TextHandlingEnum::PRESERVEFORMATTING_ON);

        $this->streamFactory->expects(self::once())
            ->method('createStream')
            ->with(
                json_encode(
                    [
                        'text' => ['some text to translate'],
                        'target_lang' => 'DE',
                        'source_lang' => 'EN',
                        'tag_handling' => 'a,b',
                        'non_splitting_tags' => 'b,a,c',
                        'ignore_tags' => 'ef,fa,qa',
                        'split_sentences' => '1',
                        'preserve_formatting' => '1',
                    ],
                )
            )
            ->willReturn($stream);

        self::assertSame($stream, $this->subject->getBody());
    }

    #[Test]
    public function getMethod(): void
    {
        self::assertSame(DeeplRequestHandlerInterface::METHOD_POST, $this->subject->getMethod());
    }

    #[Test]
    public function getContentType(): void
    {
        self::assertSame('application/json', $this->subject->getContentType());
    }
}
