<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class GlossaryIdSubmissionTest extends TestCase
{
    /**
     * @var GlossaryIdSubmission
     */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new GlossaryIdSubmission();
    }

    public function testGetIdReturnString(): void
    {
        $value = 'some value';
        self::assertSame($value, $this->subject->setId($value)->getId());
    }
}
