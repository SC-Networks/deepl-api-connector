<?php

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

    public function testGetDocumentIdCanReturnString()
    {
        $value = 'some value';
        $this->assertSame(
            $value,
            $this->subject->setDocumentId($value)->getDocumentId()
        );
    }

    public function testGetStatusCanReturnString()
    {
        $value = 'some value';
        $this->assertSame(
            $value,
            $this->subject->setStatus($value)->getStatus()
        );
    }

    public function testGetSecondsRemainingCanReturnInteger()
    {
        $value = 1234;
        $this->assertSame(
            $value,
            $this->subject->setSecondsRemaining($value)->getSecondsRemaining()
        );
    }

    public function testGetBilledCharractersCanReturnInteger()
    {
        $value = 1234;
        $this->assertSame(
            $value,
            $this->subject->setBilledCharacters($value)->getBilledCharacters()
        );
    }
}
