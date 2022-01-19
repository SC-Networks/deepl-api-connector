# deepl-api-connector - Unofficial PHP Client for the API of deepl.com.

[![Monthly Downloads](https://poser.pugx.org/scn/deepl-api-connector/d/monthly)](https://packagist.org/packages/scn/deepl-api-connector)
[![License](https://poser.pugx.org/scn/deepl-api-connector/license)](LICENSE)
[![Build Status](https://travis-ci.org/SC-Networks/deepl-api-connector.svg?branch=master)](https://travis-ci.org/SC-Networks/deepl-api-connector)

Information about Deepl: https://www.deepl.com
Information about Deepl API: https://www.deepl.com/api.html

## Install

Via Composer

``` bash
$ composer require scn/deepl-api-connector
```

## Usage

#### Get Usage of API Key

```php
require_once __DIR__  . '/vendor/autoload.php';

$deepl = \Scn\DeeplApiConnector\DeeplClientFactory::create('your-api-key');

try {
    $usageObject = $deepl->getUsage();
    
    
    .......
}
```

#### Get Translation

```php
require_once __DIR__  . '/vendor/autoload.php';

$deepl = \Scn\DeeplApiConnector\DeeplClientFactory::create('your-api-key');

try {
    $translation = new \Scn\DeeplApiConnector\Model\TranslationConfig(
        'My little Test',
        \Scn\DeeplApiConnector\Enum\LanguageEnum::LANGUAGE_DE
        ...,
        ...,
    );

    $translationObject = $deepl->getTranslation($translation);
        
    .......
    
    OR
    
    $translationObject = $deepl->translate('some text', \Scn\DeeplApiConnector\Model\TranslationConfigInterface::LANGUAGE_DE);
}
```

#### Add File to Translation Queue

```php
require_once __DIR__  . '/vendor/autoload.php';

$deepl = \Scn\DeeplApiConnector\DeeplClientFactory::create('your-api-key');

try {
    $fileTranslation = new \Scn\DeeplApiConnector\Model\FileTranslationConfig(
        file_get_contents('test.txt'),
        'test.txt',
        \Scn\DeeplApiConnector\Enum\LanguageEnum::LANGUAGE_EN,
        \Scn\DeeplApiConnector\Enum\LanguageEnum::LANGUAGE_DE
    );

    $fileSubmission = $deepl->translateFile($fileTranslation);

    $fileSubmission->getDocumentId() 
    
    .....
}
```

#### Check File Translation Status

```php
require_once __DIR__  . '/vendor/autoload.php';

$deepl = \Scn\DeeplApiConnector\DeeplClientFactory::create('your-api-key');

try {
    $fileTranslation = new \Scn\DeeplApiConnector\Model\FileTranslationConfig(
        file_get_contents('test.txt'),
        'test.txt',
        \Scn\DeeplApiConnector\Enum\LanguageEnum::LANGUAGE_EN,
        \Scn\DeeplApiConnector\Enum\LanguageEnum::LANGUAGE_DE
    );

    $fileSubmission = $deepl->translateFile($fileTranslation);

    $translationStatus = $deepl->getFileTranslationStatus($fileSubmission);
    
    if ($translationStatus->getStatus() === \Scn\DeeplApiConnector\Enum\FileStatusEnum::FILE_TRANSLATION_DONE)
    {
    ....
    }
}
```

#### Get Translated File Content

```php
require_once __DIR__  . '/vendor/autoload.php';

$deepl = \Scn\DeeplApiConnector\DeeplClientFactory::create('your-api-key');

try {
    $fileTranslation = new \Scn\DeeplApiConnector\Model\FileTranslationConfig(
        file_get_contents('test.txt'),
        'test.txt',
        \Scn\DeeplApiConnector\Enum\LanguageEnum::LANGUAGE_EN,
        \Scn\DeeplApiConnector\Enum\LanguageEnum::LANGUAGE_DE
    );

    $fileSubmission = $deepl->translateFile($fileTranslation);

    $file = $deepl->getFileTranslation($fileSubmission);

    echo $file->getContent();
    .....
}
```

## HttpClient Implementation

If a custom HTTP client implementation is to be used, this can also be done via the DeeplClientFactory::create method. 
The Client must support PSR18.

```php
require_once __DIR__  . '/vendor/autoload.php';

$deepl = \Scn\DeeplApiConnector\DeeplClientFactory::create('your-api-key', new AweSomeHttpClient());
```

## Testing

``` bash
$ composer test
```

## Credits

- [Deepl](https://www.deepl.com)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
