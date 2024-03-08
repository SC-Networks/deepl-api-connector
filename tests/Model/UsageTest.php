<?php

declare(strict_types=1);

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

    public function testGetCharacterCountCanReturnInt(): void
    {
        $this->subject->setCharacterCount(10);
        self::assertSame(10, $this->subject->getCharacterCount());
    }

    public function testGetCharacterLimitCanReturnInt(): void
    {
        $this->subject->setCharacterLimit(123_456_789);
        self::assertSame(123_456_789, $this->subject->getCharacterLimit());
    }

    public function testHydrateCanHydrateUsageStdClass(): void
    {
        $demo_response = json_decode('{ "character_count": 180118, "character_limit": 1250000, "some_other": 123 }');

        $this->subject->hydrate($demo_response);
        self::assertEquals(180118, $this->subject->getCharacterCount());
        self::assertEquals(1_250_000, $this->subject->getCharacterLimit());
    }
}
