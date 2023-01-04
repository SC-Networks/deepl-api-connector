<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Enum\TextHandlingEnum;
use Scn\DeeplApiConnector\Model\BatchTranslationConfigInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplBatchTranslationRequestHandlerTest extends TestCase
{
    private DeeplBatchTranslationRequestHandler $subject;

    /** @var StreamFactoryInterface|MockObject */
    private $streamFactory;

    /** @var BatchTranslationConfigInterface|MockObject */
    private $translation;

    protected function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);
        $this->translation = $this->createMock(BatchTranslationConfigInterface::class);

        $this->subject = new DeeplBatchTranslationRequestHandler(
            'some key',
            $this->streamFactory,
            $this->translation
        );
    }

    public function testGetPathCanReturnPath(): void
    {
        static::assertSame(DeeplTranslationRequestHandler::API_ENDPOINT, $this->subject->getPath());
    }

    public function testGetBodyCanReturnFilteredArray(): void
    {
        $text1 = 'some-text';
        $text2 = 'some-other-text';

        $stream = $this->createMock(StreamInterface::class);

        $query = http_build_query(
            [
                'target_lang' => 'some target language',
                'auth_key' => 'some key',
            ]
        );

        $query .= sprintf('&text=%s', $text1);
        $query .= sprintf('&text=%s', $text2);

        $this->translation->expects($this->once())
            ->method('getText')
            ->willReturn([$text1, $text2]);

        $this->translation->expects($this->once())
            ->method('getTargetLang')
            ->willReturn('some target language');

        $this->streamFactory->expects($this->once())
            ->method('createStream')
            ->with($query)
            ->willReturn($stream);

        static::assertSame(
            $stream,
            $this->subject->getBody()
        );
    }

    public function testGetBodyCanReturnArrayWithOptionalTags(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $text = 'some text to translate';

        $query = http_build_query(
            [
                'target_lang' => 'some target language',
                'tag_handling' => 'a,b',
                'non_splitting_tags' => 'b,a,c',
                'ignore_tags' => 'ef,fa,qa',
                'split_sentences' => '1',
                'preserve_formatting' => '1',
                'auth_key' => 'some key',
            ]
        );

        $query .= sprintf('&text=%s', $text);

        $this->translation->expects($this->once())
            ->method('getText')
            ->willReturn([$text]);

        $this->translation->expects($this->once())
            ->method('getTargetLang')
            ->willReturn('some target language');

        $this->translation->expects($this->once())
            ->method('getTagHandling')
            ->willReturn(['a', 'b']);

        $this->translation->expects($this->once())
            ->method('getNonSplittingTags')
            ->willReturn(['b', 'a', 'c']);

        $this->translation->expects($this->once())
            ->method('getIgnoreTags')
            ->willReturn(['ef', 'fa', 'qa']);

        $this->translation->expects($this->once())
            ->method('getSplitSentences')
            ->willReturn(TextHandlingEnum::SPLITSENTENCES_ON);

        $this->translation->expects($this->once())
            ->method('getPreserveFormatting')
            ->willReturn(TextHandlingEnum::PRESERVEFORMATTING_ON);

        $this->streamFactory->expects($this->once())
            ->method('createStream')
            ->with($query)
            ->willReturn($stream);

        static::assertSame(
            $stream,
            $this->subject->getBody()
        );
    }

    public function testGetMethodCanReturnMethod(): void
    {
        static::assertSame(DeeplRequestHandlerInterface::METHOD_POST, $this->subject->getMethod());
    }

    public function testGetContentTypeReturnsValue(): void
    {
        static::assertSame(
            'application/x-www-form-urlencoded',
            $this->subject->getContentType()
        );
    }
}
