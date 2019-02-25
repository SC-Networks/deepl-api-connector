<?php

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\TranslationConfigInterface;
use Scn\DeeplApiConnector\TestCase;

/**
 * Class TranslationRequestHandlerTest
 *
 * @package Scn\DeeplApiConnector\Handler
 */
class TranslationRequestHandlerTest extends TestCase
{

    /**
     * @var DeeplTranslationRequestHandler
     */
    private $subject;

    /**
     * @var TranslationConfigInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $translation;

    public function setUp(): void
    {
        $this->translation = $this->createMock(TranslationConfigInterface::class);

        $this->subject = new DeeplTranslationRequestHandler(
            'some key',
            $this->translation
        );
    }

    public function testGetPathCanReturnPath()
    {
        $this->assertSame(DeeplTranslationRequestHandler::API_ENDPOINT, $this->subject->getPath());
    }

    public function testGetBodyCanReturnFilteredArray()
    {
        $this->translation->expects($this->once())
            ->method('getText')
            ->willReturn('some text to translate');

        $this->translation->expects($this->once())
            ->method('getTargetLang')
            ->willReturn('some target language');

        $this->assertSame(
            [
                'form_params' =>
                    [
                        'text' => 'some text to translate',
                        'target_lang' => 'some target language',
                        'auth_key' => 'some key'
                    ]
            ],
            $this->subject->getBody()
        );
    }

    public function testGetBodyCanReturnArrayWithOptionalTags()
    {
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
            ->willReturn(1);

        $this->translation->expects($this->once())
            ->method('getPreserveFormatting')
            ->willReturn(0);

        $this->assertSame(
            [
                'form_params' =>
                    [
                        'text' => 'some text to translate',
                        'target_lang' => 'some target language',
                        'source_lang' => 'some source lang',
                        'tag_handling' => 'a,b',
                        'non_splitting_tags' => 'b,a,c',
                        'ignore_tags' => 'ef,fa,qa',
                        'split_sentences' => '1',
                        'auth_key' => 'some key',
                    ]
            ],
            $this->subject->getBody()
        );
    }

    public function testGetMethodCanReturnMethod()
    {
        $this->assertSame(DeeplRequestHandlerInterface::METHOD_POST, $this->subject->getMethod());
    }
}
