<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\Enum\TextHandlingEnum;
use Scn\DeeplApiConnector\TestCase;

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

    public function testGetNonSplittingTagsCanReturnString(): void
    {
        $this->subject->setNonSplittingTags(['some', 'splitting', 'tags']);
        $this->assertContains('some', $this->subject->getNonSplittingTags());
        $this->assertContains('splitting', $this->subject->getNonSplittingTags());
        $this->assertContains('tags', $this->subject->getNonSplittingTags());
    }

    public function testGetIgnoreTagsCanReturnString(): void
    {
        $this->subject->setIgnoreTags(['some', 'ignore', 'tags']);
        $this->assertContains('some', $this->subject->getIgnoreTags());
        $this->assertContains('ignore', $this->subject->getIgnoreTags());
        $this->assertContains('tags', $this->subject->getIgnoreTags());
    }

    public function testGetPreserveFormattingCanReturnInteger(): void
    {
        $this->subject->setPreserveFormatting(TextHandlingEnum::PRESERVEFORMATTING_ON);
        $this->assertSame('1', $this->subject->getPreserveFormatting());
    }

    public function testGetTargetLangCanReturnString(): void
    {
        $this->subject->setTargetLang('some target lang');
        $this->assertSame('some target lang', $this->subject->getTargetLang());
    }

    public function testGetTagHandlingCanReturnString(): void
    {
        $this->subject->setTagHandling(['some', 'tags']);
        $this->assertContains('some', $this->subject->getTagHandling());
        $this->assertContains('tags', $this->subject->getTagHandling());
    }

    public function testGetTextCanReturnString(): void
    {
        $this->subject->setText('some text to translate');
        $this->assertSame('some text to translate', $this->subject->getText());
    }

    public function testGetSourceLangCanReturnString(): void
    {
        $this->subject->setSourceLang('some source lang');
        $this->assertSame('some source lang', $this->subject->getSourceLang());
    }

    public function testGetSplitSentencesCanReturnInteger(): void
    {
        $this->subject->setSplitSentences(TextHandlingEnum::SPLITSENTENCES_NONEWLINES);
        $this->assertSame(TextHandlingEnum::SPLITSENTENCES_NONEWLINES, $this->subject->getSplitSentences());
    }
}
