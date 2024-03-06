<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Scn\DeeplApiConnector\DeeplClientFactory;
use Scn\DeeplApiConnector\Enum\GlossarySubmissionEntryFormatEnum;
use Scn\DeeplApiConnector\Model\GlossariesListInterface;
use Scn\DeeplApiConnector\Model\GlossaryEntries;
use Scn\DeeplApiConnector\Model\GlossaryIdSubmission;
use Scn\DeeplApiConnector\Model\GlossaryInterface;
use Scn\DeeplApiConnector\Model\GlossarySubmission;
use Scn\DeeplApiConnector\Model\GlossariesSupportedLanguagesPairsInterface;
use Scn\DeeplApiConnector\Model\TranslationConfig;

$apiKey = 'your-api-key';

$deepl = DeeplClientFactory::create($apiKey);

/** @var GlossariesSupportedLanguagesPairsInterface $result */
$result = $deepl->getGlossariesSupportedLanguagesPairs();
/**
 * List all available pairs
 */
var_dump($result->getList());

/** @var GlossariesListInterface $result */
$result = $deepl->getGlossariesList();
/**
 * List all glossaries
 */
var_dump($result->getList());

$input = (new GlossarySubmission())
    ->setName('en => nl')
    ->setSourceLang('en')
    ->setTargetLang('nl')
    ->setEntries("Hello\tDag\nDog\tHond");

// NB.: Note that entries can be a tsv or csv. Related to the documentation : https://www.deepl.com/fr/docs-api/glossaries/formats
// To use CSV, this is the example :

$input->setEntriesFormat(GlossarySubmissionEntryFormatEnum::FORMAT_CSV)
    ->setEntries("Hello,Dag\nDog,Hond");
/** @var GlossaryInterface $glossary */
$glossary = $deepl->createGlossary($input);
/**
 * Get created glossary
 */
var_dump($glossary->getDetails());

$input = (new GlossaryIdSubmission())
    ->setId($glossary->getDetails()['glossary_id']);
/** @var GlossaryInterface $result */
$result = $deepl->retrieveGlossary($input);
/**
 * Get glossary details
 */
var_dump($result->getDetails());

/** @var GlossaryEntries $result */
$result = $deepl->retrieveGlossaryEntries($input);
/**
 * Get glossary entries array
 */
var_dump($result->getList());
/**
 * Get glossary entries real result
 */
var_dump($result->getResult());

$result = $deepl->deleteGlossary($input);
/**
 * True if glossary successfully deleted
 */
var_dump($result);

/**
 * Now, whe can get the glossary from the source and target lang and use it in the TranslationConfig
 */
$source = 'en';
$target = 'nl';
/** @var GlossariesListInterface $glossaries */
$glossaries = $deepl->getGlossariesList();
$glossary = current(array_filter(
    $glossaries->getList(),
    fn (array $e) => $e['source_lang'] === $source && $e['target_lang'] === $target
));

$translationConfig = new TranslationConfig(
    'Hello World',
    $target,
    $source,
    glossaryId: $glossary !== false ? $glossary['glossary_id'] : ''
);
$translationObj = $deepl->getTranslation($translationConfig);
var_dump($translationObj);
