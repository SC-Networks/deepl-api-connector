<?php

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

/**
 * Class TranslationConfigTest
 *
 * @package Scn\DeeplApiConnector\Model
 */
class TranslationConfigTest extends TestCase
{

    /**
     * @var TranslationConfig
     */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new TranslationConfig(
            'some text',
            'some target language'
        );
    }

    public function testGetNonSplittingTagsCanReturnString()
    {
        $this->subject->setNonSplittingTags(['some', 'splitting', 'tags']);
        $this->assertContains('some', $this->subject->getNonSplittingTags());
        $this->assertContains('splitting', $this->subject->getNonSplittingTags());
        $this->assertContains('tags', $this->subject->getNonSplittingTags());
    }

    public function testGetIgnoreTagsCanReturnString()
    {
        $this->subject->setIgnoreTags(['some', 'ignore', 'tags']);
        $this->assertContains('some', $this->subject->getIgnoreTags());
        $this->assertContains('ignore', $this->subject->getIgnoreTags());
        $this->assertContains('tags', $this->subject->getIgnoreTags());
    }

    public function testGetPreserveFormattingCanReturnBool()
    {
        $this->subject->setPreserveFormatting(true);
        $this->assertTrue($this->subject->getPreserveFormatting());
    }

    public function testGetTargetLangCanReturnString()
    {
        $this->subject->setTargetLang('some target lang');
        $this->assertSame('some target lang', $this->subject->getTargetLang());
    }

    public function testGetTagHandlingCanReturnString()
    {
        $this->subject->setTagHandling(['some', 'tags']);
        $this->assertContains('some', $this->subject->getTagHandling());
        $this->assertContains('tags', $this->subject->getTagHandling());
    }

    public function testGetTextCanReturnString()
    {
        $this->subject->setText('some text to translate');
        $this->assertSame('some text to translate', $this->subject->getText());
    }

    public function testGetSourceLangCanReturnString()
    {
        $this->subject->setSourceLang('some source lang');
        $this->assertSame('some source lang', $this->subject->getSourceLang());
    }

    public function testGetSplitSentencesCanReturnBool()
    {
        $this->subject->setSplitSentences(false);
        $this->assertFalse($this->subject->getSplitSentences());
    }
}
