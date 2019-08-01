<?php

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\Enum\LanguageEnum;
use Scn\DeeplApiConnector\TestCase;

class FileTranslationConfigTest extends TestCase
{
    /**
     * @var FileTranslationConfig
     */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new FileTranslationConfig(
            'abc',
            'abc.txt',
            LanguageEnum::LANGUAGE_EN,
            LanguageEnum::LANGUAGE_DE
        );
    }

    public function testGetFileContentCanReturnString()
    {
        $this->assertSame(
            'abc',
            $this->subject->getFileContent()
        );
    }

    public function testGetFileNameCanReturnString()
    {
        $this->assertSame(
            'abc.txt',
            $this->subject->getFileName()
        );
    }

    public function testGetTargetLangCanReturnString()
    {
        $this->assertSame(
            LanguageEnum::LANGUAGE_EN,
            $this->subject->getTargetLang()
        );
    }

    public function testGetSourceLangCanReturnString()
    {
        $this->assertSame(
            LanguageEnum::LANGUAGE_DE,
            $this->subject->getSourceLang()
        );
    }
}
