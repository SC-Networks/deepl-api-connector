<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class GlossaryTest extends TestCase
{
    private Glossary $subject;

    protected function setUp(): void
    {
        $this->subject = new Glossary();
    }

    public function testGetLanguagesReturnHydratedValues(): void
    {
        $glossary1 = [
            'glossary_id' => 'fea20bcb-af84-4e1e-ba40-24d64d789df3',
            'ready' => true,
            'name' => 'en => nl',
            'source_lang' => 'en',
            'target_lang' => 'nl',
            'creation_time' => '2024-03-06T13:05:42.030634Z',
            'entry_count' => 1,
        ];

        $this->subject->hydrate((object)$glossary1);

        static::assertSame(
            $glossary1,
            $this->subject->getDetails()
        );
    }
}
