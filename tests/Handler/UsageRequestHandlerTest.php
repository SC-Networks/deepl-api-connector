<?php

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\TestCase;

/**
 * Class UsageRequestHandlerTest
 *
 * @package Scn\DeeplApiConnector\Handler
 */
class UsageRequestHandlerTest extends TestCase
{

    /**
     * @var DeeplUsageRequestHandler
     */
    private $subject;

    public function setUp()
    {
        $this->subject = new DeeplUsageRequestHandler(
            'some key'
        );
    }

    public function testGetPathCanReturnApiPath()
    {
        $this->assertSame(DeeplUsageRequestHandler::API_ENDPOINT, $this->subject->getPath());
    }

    public function testGetMethodCanReturnMethod()
    {
        $this->assertSame(DeeplRequestHandlerInterface::METHOD_GET, $this->subject->getMethod());
    }

    public function testGetBodyCanReturnArray()
    {
        $this->assertArraySubset(['form_params' => ['auth_key' => 'some key']], $this->subject->getBody());
    }
}
