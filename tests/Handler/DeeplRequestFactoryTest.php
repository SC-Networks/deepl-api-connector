<?php

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\TranslationConfigInterface;
use Scn\DeeplApiConnector\TestCase;

class DeeplRequestFactoryTest extends TestCase
{

    /**
     * @var DeeplRequestFactory
     */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new DeeplRequestFactory(
            'some api key'
        );
    }

    public function testCreateDeeplUsageRequestHandlerCanReturnInstanceOfUsageRequestHandler()
    {
        $this->assertInstanceOf(
            DeeplUsageRequestHandler::class,
            $this->subject->createDeeplUsageRequestHandler()
        );
    }

    public function testCreateDeeplTranslationRequestHandler()
    {
        $translation = $this->createMock(TranslationConfigInterface::class);
        $this->assertInstanceOf(
            DeeplTranslationRequestHandler::class,
            $this->subject->createDeeplTranslationRequestHandler($translation)
        );
    }
}
