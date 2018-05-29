<?php

namespace Scn\DeeplApiConnector\Handler;

/**
 * Class DeeplUsageRequestHandler
 *
 * @package Scn\DeeplApiConnector\Handler
 */
final class DeeplUsageRequestHandler implements DeeplRequestHandlerInterface
{

    const API_ENDPOINT = 'https://api.deepl.com/v1/usage';

    /**
     * @var string
     */
    private $authKey;

    /**
     * DeeplUsageRequestHandler constructor.
     *
     * @param string $authKey
     */
    public function __construct($authKey)
    {
        $this->authKey = $authKey;
    }

    /**
     *
     * @return string
     */
    public function getMethod()
    {
        return DeeplRequestHandlerInterface::METHOD_GET;
    }

    /**
     *
     * @return string
     */
    public function getPath()
    {
        return static::API_ENDPOINT;
    }

    /**
     *
     * @return array
     */
    public function getBody()
    {
        return [
            'form_params' => array_filter(
                [
                    'auth_key' => $this->authKey
                ]
            )
        ];
    }
}