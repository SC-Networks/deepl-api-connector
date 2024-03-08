<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class FileTranslationStatusTest extends TestCase
{
    /**
     * @var FileTranslationStatus
     */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new FileTranslationStatus();
    }

    public function testGetDocumentIdCanReturnString(): void
    {
        $value = 'some value';
        self::assertSame($value, $this->subject->setDocumentId($value)->getDocumentId());
    }

    public function testGetStatusCanReturnString(): void
    {
        $value = 'some value';
        self::assertSame($value, $this->subject->setStatus($value)->getStatus());
    }

    public function testGetSecondsRemainingCanReturnInteger(): void
    {
        $value = 1234;
        self::assertSame($value, $this->subject->setSecondsRemaining($value)->getSecondsRemaining());
    }

    public function testGetBilledCharactersCanReturnInteger(): void
    {
        $value = 1234;
        self::assertSame($value, $this->subject->setBilledCharacters($value)->getBilledCharacters());
    }
}
