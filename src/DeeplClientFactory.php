<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Scn\DeeplApiConnector\Handler\DeeplRequestFactory;

/**
 * Provides a factory method to create an instance by passing custom dependencies or using defaults
 */
final class DeeplClientFactory
{
    public static function create(
        string $authKey,
        ClientInterface $httpClient = null,
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface $streamFactory = null
    ): DeeplClientInterface {
        return new DeeplClient(
            new DeeplRequestFactory(
                $authKey,
                $streamFactory ?: Psr17FactoryDiscovery::findStreamFactory()
            ),
            $httpClient ?: Psr18ClientDiscovery::find(),
            $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory()
        );
    }
}
