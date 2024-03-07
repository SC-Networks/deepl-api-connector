<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class GlossaryEntriesTest extends TestCase
{
    private GlossaryEntries $subject;

    protected function setUp(): void
    {
        $this->subject = new GlossaryEntries();
    }

    public function testGetLanguagesReturnHydratedValues(): void
    {
        $string = "Test\ttest\nTest2\ttest";
        $this->subject->hydrate((object)['content' => $string]);

        static::assertSame(
            [
                [
                    'source' => 'Test',
                    'target' => 'test',
                ],
                [
                    'source' => 'Test2',
                    'target' => 'test',
                ],
            ],
            $this->subject->getList()
        );

        static::assertSame(
            $string,
            $this->subject->getResult()
        );
    }
}
