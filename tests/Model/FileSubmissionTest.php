<?php

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class FileSubmissionTest extends TestCase
{
    /**
     * @var FileSubmission
     */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new FileSubmission();
    }

    public function testGetDocumentIdCanReturnString()
    {
        $value = 'some value';
        $this->assertSame(
            $value,
            $this->subject->setDocumentId($value)->getDocumentId()
        );
    }

    public function testGetDocumentKeyCanReturnString()
    {
        $value = 'some value';
        $this->assertSame(
            $value,
            $this->subject->setDocumentKey($value)->getDocumentKey()
        );
    }
}
