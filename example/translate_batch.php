<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Scn\DeeplApiConnector\DeeplClientFactory;

$apiKey = 'your-api-key';

$deepl = DeeplClientFactory::create($apiKey);

/** @var \Scn\DeeplApiConnector\Model\BatchTranslationInterface $result */
$result = $deepl->translateBatch(['das ist ein test', 'heute habe ich hunger'], 'en');

var_dump($result->getTranslations());
