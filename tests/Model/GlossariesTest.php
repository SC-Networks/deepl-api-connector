<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class GlossariesTest extends TestCase
{
    private Glossaries $subject;

    protected function setUp(): void
    {
        $this->subject = new Glossaries();
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
        $glossary2 = [
            'glossary_id' => 'ac7780ac-bd63-4e64-9ec3-0e82aa2c4825',
            'ready' => true,
            'name' => 'fr => de',
            'source_lang' => 'fr',
            'target_lang' => 'de',
            'creation_time' => '2024-03-06T13:26:09.791227Z',
            'entry_count' => 2,
        ];
        $glossary3 = [
            'glossary_id' => '9cc8f5b1-3096-44a4-8a22-3e8b337471cd',
            'ready' => true,
            'name' => 'fr => en',
            'source_lang' => 'fr',
            'target_lang' => 'en',
            'creation_time' => '2024-03-06T14:12:20.589969Z',
            'entry_count' => 1,
        ];
        $glossaries = [
            (object)$glossary1,
            (object)$glossary2,
            (object)$glossary3,
        ];
        $result = [
            'glossaries' => $glossaries
        ];

        $this->subject->hydrate((object)$result);

        static::assertSame(
            [$glossary1, $glossary2, $glossary3],
            $this->subject->getList()
        );
    }
}
