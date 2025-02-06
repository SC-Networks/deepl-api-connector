<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Scn\DeeplApiConnector\DeeplClientFactory;

$apiKey = 'your-api-key';

$usage = DeeplClientFactory::create($apiKey)
    ->getUsage();

var_dump($usage);
