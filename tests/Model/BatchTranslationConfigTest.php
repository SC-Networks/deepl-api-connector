<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\Enum\TextHandlingEnum;
use Scn\DeeplApiConnector\TestCase;

class BatchTranslationConfigTest extends TestCase
{
    private BatchTranslationConfig $subject;

    protected function setUp(): void
    {
        $this->subject = new BatchTranslationConfig(
            ['some text'],
            'some target language'
        );
    }

    public function testGetNonSplittingTagsCanReturnString(): void
    {
        $this->subject->setNonSplittingTags(['some', 'splitting', 'tags']);

        static::assertContains('some', $this->subject->getNonSplittingTags());
        static::assertContains('splitting', $this->subject->getNonSplittingTags());
        static::assertContains('tags', $this->subject->getNonSplittingTags());
    }

    public function testGetIgnoreTagsCanReturnString(): void
    {
        $this->subject->setIgnoreTags(['some', 'ignore', 'tags']);

        static::assertContains('some', $this->subject->getIgnoreTags());
        static::assertContains('ignore', $this->subject->getIgnoreTags());
        static::assertContains('tags', $this->subject->getIgnoreTags());
    }

    public function testGetPreserveFormattingCanReturnInteger(): void
    {
        $this->subject->setPreserveFormatting(TextHandlingEnum::PRESERVEFORMATTING_ON);

        static::assertSame('1', $this->subject->getPreserveFormatting());
    }

    public function testGetTargetLangCanReturnString(): void
    {
        $this->subject->setTargetLang('some target lang');

        static::assertSame('some target lang', $this->subject->getTargetLang());
    }

    public function testGetTagHandlingCanReturnString(): void
    {
        $this->subject->setTagHandling(['some', 'tags']);

        static::assertContains('some', $this->subject->getTagHandling());
        static::assertContains('tags', $this->subject->getTagHandling());
    }

    public function testGetTextCanReturnString(): void
    {
        $value = ['some text to translate'];

        $this->subject->setText($value);

        static::assertSame($value, $this->subject->getText());
    }

    public function testGetSplitSentencesCanReturnInteger(): void
    {
        $this->subject->setSplitSentences(TextHandlingEnum::SPLITSENTENCES_NONEWLINES);

        static::assertSame(TextHandlingEnum::SPLITSENTENCES_NONEWLINES, $this->subject->getSplitSentences());
    }
}
