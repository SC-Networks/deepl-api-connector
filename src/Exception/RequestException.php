<?php

namespace Scn\DeeplApiConnector\Exception;

use Exception;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * NOTE: Use `getPrevious()` to access the initial
 * {@see ClientExceptionInterface} exception that was
 * triggered.
 *
 * Depending on the HTTP implementation (e.g. GuzzleHttp),
 * this can allow access to additional information
 * (HTTP response details, for example).
 */
class RequestException extends Exception
{
}
