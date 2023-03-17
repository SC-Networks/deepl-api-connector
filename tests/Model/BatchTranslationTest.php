<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class BatchTranslationTest extends TestCase
{
    private BatchTranslation $subject;

    protected function setUp(): void
    {
        $this->subject = new BatchTranslation();
    }

    public function testHydrateCanHydrateUsageStdClass(): void
    {
        $text1 = 'some-text';
        $text2 = 'some-other-text';
        $detected_language = 'klingon';

        $response = json_encode([
            'translations' => [
                ['text' => $text1, 'detected_source_language' => $detected_language],
                ['text' => $text2, 'detected_source_language' => $detected_language],
            ]
        ]);

        $this->subject->hydrate(json_decode($response));

        static::assertSame(
            [
                ['text' => $text1, 'detected_source_language' => $detected_language],
                ['text' => $text2, 'detected_source_language' => $detected_language],
            ],
            $this->subject->getTranslations()
        );
    }

    public function testSetTranslationsCanSettArrayOfTextAndCanReturnSelf(): void
    {
        $this->assertInstanceOf(
            BatchTranslationInterface::class,
            $this->subject->setTranslations(['some', 'thing'])
        );
    }
}
