<?php

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

class DeeplRequestFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DeeplRequestFactory
     */
    private $subject;

    public function setUp()
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
