<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class DeeplClientFactoryTest extends TestCase
{
    public function testCreateReturnsClientWithCustomLibraries(): void
    {
        $client = $this->createMock(ClientInterface::class);
        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $streamFactory = $this->createMock(StreamFactoryInterface::class);
        
        $authKey = 'some-auth-key';
        
        $this->assertInstanceOf(
            DeeplClientInterface::class,
            DeeplClientFactory::create(
                $authKey,
                $client,
                $requestFactory,
                $streamFactory
            )
        );
    }
    
    public function testCreateReturnsClientWithAutoDisovery(): void
    {
        $authKey = 'some-auth-key';

        $this->assertInstanceOf(
            DeeplClientInterface::class,
            DeeplClientFactory::create(
                $authKey
            )
        );
    }
}
