<?php

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

    public function testGetContentCanReturnString()
    {
        $this->subject->setContent('some content');
        $this->assertSame(
           'some content',
           $this->subject->getContent()
        );
    }
}
