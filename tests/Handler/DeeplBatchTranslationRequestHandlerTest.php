<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Enum\TextHandlingEnum;
use Scn\DeeplApiConnector\Model\BatchTranslationConfigInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplBatchTranslationRequestHandlerTest extends TestCase
{
    private DeeplBatchTranslationRequestHandler $subject;

    private StreamFactoryInterface&MockObject $streamFactory;

    private BatchTranslationConfigInterface&MockObject $translation;

    protected function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);
        $this->translation = $this->createMock(BatchTranslationConfigInterface::class);

        $this->subject = new DeeplBatchTranslationRequestHandler(
            $this->streamFactory,
            $this->translation,
        );
    }

    public function testGetPathCanReturnPath(): void
    {
        self::assertSame(DeeplTranslationRequestHandler::API_ENDPOINT, $this->subject->getPath());
    }

    #[Test]
    public function getBodyFiltered(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $query = json_encode(
            [
            'target_lang' => $lang = 'DE',
            'text' => [
                $text1 = 'some-text',
                $text2 = 'some-other-text',
            ]],
        );

        $this->translation->expects(self::once())
            ->method('getText')
            ->willReturn([$text1, $text2]);

        $this->translation->expects(self::once())
            ->method('getTargetLang')
            ->willReturn($lang);

        $this->streamFactory->expects(self::once())
            ->method('createStream')
            ->with($query)
            ->willReturn($stream);

        self::assertSame(
            $stream,
            $this->subject->getBody(),
        );
    }

    #[Test]
    public function getBodyWithOptionalTags(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $text = 'some text to translate';

        $body = json_encode(
            [
                'target_lang' => 'some target language',
                'tag_handling' => 'a,b',
                'non_splitting_tags' => 'b,a,c',
                'ignore_tags' => 'ef,fa,qa',
                'split_sentences' => '1',
                'preserve_formatting' => '1',
                'text' => [$text],
            ]
        );

        $this->translation->expects(self::once())
            ->method('getText')
            ->willReturn([$text]);

        $this->translation->expects(self::once())
            ->method('getTargetLang')
            ->willReturn('some target language');

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
            ->with($body)
            ->willReturn($stream);

        self::assertSame(
            $stream,
            $this->subject->getBody(),
        );
    }

    #[Test]
    public function getMethod(): void
    {
        self::assertSame(DeeplRequestHandlerInterface::METHOD_POST, $this->subject->getMethod());
    }

    #[Test]
    public function getContentType(): void
    {
        self::assertSame(
            'application/json',
            $this->subject->getContentType(),
        );
    }
}
