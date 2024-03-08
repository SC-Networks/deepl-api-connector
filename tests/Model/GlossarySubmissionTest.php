<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class GlossarySubmissionTest extends TestCase
{
    /**
     * @var GlossarySubmission
     */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new GlossarySubmission();
    }

    public function testGetNameReturnString(): void
    {
        $value = 'some value';
        self::assertSame($value, $this->subject->setName($value)->getName());
    }
    public function testGetSourceLangReturnString(): void
    {
        $value = 'some value';
        self::assertSame($value, $this->subject->setSourceLang($value)->getSourceLang());
    }
    public function testGetTargetLangReturnString(): void
    {
        $value = 'some value';
        self::assertSame($value, $this->subject->setTargetLang($value)->getTargetLang());
    }
    public function testGetEntriesReturnString(): void
    {
        $value = 'some value';
        self::assertSame($value, $this->subject->setEntries($value)->getEntries());
    }
    public function testGetEntriesFormatReturnString(): void
    {
        $value = 'some value';
        self::assertSame($value, $this->subject->setEntriesFormat($value)->getEntriesFormat());
    }
}
