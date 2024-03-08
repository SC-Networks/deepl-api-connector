<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Enum\TextHandlingEnum;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplTranslationRequestHandlerTest extends TestCase
{
    /**
     * @var DeeplTranslationRequestHandler
     */
    private $subject;

    /** @var StreamFactoryInterface|MockObject */
    private $streamFactory;

    /**
     * @var TranslationConfigInterface|MockObject
     */
    private $translation;

    public function setUp(): void
    {
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);
        $this->translation = $this->createMock(TranslationConfigInterface::class);

        $this->subject = new DeeplTranslationRequestHandler(
            'some key',
            $this->streamFactory,
            $this->translation
        );
    }

    public function testGetPathCanReturnPath(): void
    {
        self::assertSame(DeeplTranslationRequestHandler::API_ENDPOINT, $this->subject->getPath());
    }

    public function testGetBodyCanReturnFilteredArray(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $this->translation->expects($this->once())
            ->method('getText')
            ->willReturn('some text to translate');

        $this->translation->expects($this->once())
            ->method('getTargetLang')
            ->willReturn('some target language');

        $this->streamFactory->expects($this->once())
            ->method('createStream')
            ->with(
                http_build_query(
                    [
                        'text' => 'some text to translate',
                        'target_lang' => 'some target language',
                        'auth_key' => 'some key',
                    ]
                )
            )
            ->willReturn($stream);

        self::assertSame($stream, $this->subject->getBody());
    }

    public function testGetBodyCanReturnArrayWithOptionalTags(): void
    {
        $stream = $this->createMock(StreamInterface::class);

        $this->translation->expects($this->once())
            ->method('getText')
            ->willReturn('some text to translate');

        $this->translation->expects($this->once())
            ->method('getTargetLang')
            ->willReturn('some target language');

        $this->translation->expects($this->once())
            ->method('getSourceLang')
            ->willReturn('some source lang');

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
            ->with(
                http_build_query(
                    [
                        'text' => 'some text to translate',
                        'target_lang' => 'some target language',
                        'source_lang' => 'some source lang',
                        'tag_handling' => 'a,b',
                        'non_splitting_tags' => 'b,a,c',
                        'ignore_tags' => 'ef,fa,qa',
                        'split_sentences' => '1',
                        'preserve_formatting' => '1',
                        'auth_key' => 'some key',
                    ]
                )
            )
            ->willReturn($stream);

        self::assertSame($stream, $this->subject->getBody());
    }

    public function testGetMethodCanReturnMethod(): void
    {
        self::assertSame(DeeplRequestHandlerInterface::METHOD_POST, $this->subject->getMethod());
    }

    public function testGetContentTypeReturnsValue(): void
    {
        self::assertSame('application/x-www-form-urlencoded', $this->subject->getContentType());
    }
}
