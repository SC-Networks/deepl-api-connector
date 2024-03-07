<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class GlossariesSupportedLanguagesPairsTest extends TestCase
{
    private GlossariesSupportedLanguagesPairs $subject;

    protected function setUp(): void
    {
        $this->subject = new GlossariesSupportedLanguagesPairs();
    }

    public function testGetLanguagesReturnHydratedValues(): void
    {
        $lang1 = [
            'source_lang'=> 'de',
            'target_lang'=> 'en',
        ];
        $lang2 = [
            'source_lang'=> 'de',
            'target_lang'=> 'es',
        ];
        $result = [
            'supported_languages'=> [
                (object)$lang1,
                (object)$lang2,
            ],
        ];

        $this->subject->hydrate((object)$result);

        static::assertSame(
            [$lang1, $lang2],
            $this->subject->getList()
        );
    }
}
