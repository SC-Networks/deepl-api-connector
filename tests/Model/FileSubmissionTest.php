<?php

declare(strict_types=1);

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

    public function testGetDocumentIdCanReturnString(): void
    {
        $value = 'some value';
        $this->assertSame(
            $value,
            $this->subject->setDocumentId($value)->getDocumentId()
        );
    }

    public function testGetDocumentKeyCanReturnString(): void
    {
        $value = 'some value';
        $this->assertSame(
            $value,
            $this->subject->setDocumentKey($value)->getDocumentKey()
        );
    }
}
