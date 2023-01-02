<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class SupportedLanguagesTest extends TestCase
{
    private SupportedLanguages $subject;

    protected function setUp(): void
    {
        $this->subject = new SupportedLanguages();
    }

    public function testGetLanguagesReturnHydratedValues(): void
    {
        $language = 'some-lang';
        $name = 'some language from outer space';

        $this->subject->hydrate((object) ['content' => [(object) ['language' => $language, 'name' => $name, 'supports_formality' => true]]]);

        static::assertSame(
            [
                [
                    'language_code' => $language,
                    'name' => $name,
                    'supports_formality' => true,
                ]
            ],
            $this->subject->getLanguages()
        );
    }
}
