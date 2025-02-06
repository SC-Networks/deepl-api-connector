<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Scn\DeeplApiConnector\DeeplClientFactory;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfig;

$apiKey = 'your-api-key';

$deepl = DeeplClientFactory::create($apiKey);

$fileTranslationConfig = new FileTranslationConfig(
    'Das ist ein Test',
    'testfile.txt',
    'EN',
    'DE',
);
/**
 * 1. We request a new translation with an FileTranslationConfig
 */
/** @var FileSubmissionInterface $fileSubmission */
$fileSubmission = $deepl->translateFile($fileTranslationConfig);

/**
 * Result look like a FileSubmission instance
 *
 * class Scn\DeeplApiConnector\Model\FileSubmission#22 (2) {
 * private string $documentId => "<DOCUMENT_ID>"
 * private string $documentKey => "<DOCUMENT_KEY>"
 * }
 */
var_dump($fileSubmission);

/**
 * We can simulate this by using our own instance with valid values:
 * $fileSubmission = (new FileSubmission())
 * ->setDocumentId('<DOCUMENT_ID>')
 * ->setDocumentKey('<DOCUMENT_KEY>');
 */


/** 2. We request in a queue logic the translation status with the Submission instance **/
sleep(15);
$translationStatus = $deepl->getFileTranslationStatus($fileSubmission);

/**
 * Result look like a FileTranslationStatus instance
 *
 * if the 'status' property value is 'done' we can get the fileTranslation
 *
 * class Scn\DeeplApiConnector\Model\FileTranslationStatus#43 (4) {
 * private string $documentId => "<DOCUMENT_ID>"
 * private string $status => "translating"
 * .....
 * }
 */
var_dump($translationStatus);


/** 3. We request in a queue logic the translation status with the Submission instance **/
$response = $deepl->getFileTranslation($fileSubmission);

/**
 * Result look like a FileTranslation instance
 *
 * class Scn\DeeplApiConnector\Model\FileTranslation#26 (1) {
 * private string $content => "This is a test"
 * }
 */
var_dump($response);
