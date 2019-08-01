<?php

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class UsageTest extends TestCase
{
    /**
     * @var Usage
     */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new Usage();
    }

    public function testGetCharacterCountCanReturnInt()
    {
        $this->subject->setCharacterCount(10);
        $this->assertSame(10, $this->subject->getCharacterCount());
    }

    public function testGetCharacterLimitCanReturnInt()
    {
        $this->subject->setCharacterLimit(123456789);
        $this->assertSame(123456789, $this->subject->getCharacterLimit());
    }

    public function testHydrateCanHydrateUsageStdClass()
    {
        $demo_response = json_decode('{ "character_count": 180118, "character_limit": 1250000, "some_other": 123 }');

        $this->subject->hydrate($demo_response);
        $this->assertEquals(180118, $this->subject->getCharacterCount());
        $this->assertEquals(1250000, $this->subject->getCharacterLimit());
    }
}
