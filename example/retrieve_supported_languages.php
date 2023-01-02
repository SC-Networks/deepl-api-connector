<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Scn\DeeplApiConnector\DeeplClientFactory;
use Scn\DeeplApiConnector\Model\SupportedLanguagesInterfaces;

$apiKey = 'your-api-key';

$deepl = DeeplClientFactory::create($apiKey);

/** @var SupportedLanguagesInterfaces $result */
$result = $deepl->getSupportedLanguages();

var_dump($result->getLanguages());
