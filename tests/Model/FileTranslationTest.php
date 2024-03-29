<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\TestCase;

class FileTranslationTest extends TestCase
{
    /**
     * @var FileTranslation
     */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new FileTranslation();
    }

    public function testGetContentCanReturnString(): void
    {
        $this->subject->setContent('some content');
        self::assertSame('some content', $this->subject->getContent());
    }
}
