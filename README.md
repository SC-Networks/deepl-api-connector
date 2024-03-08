# deepl-api-connector - Unofficial PHP Client for the API of deepl.com.

[![Monthly Downloads](https://poser.pugx.org/scn/deepl-api-connector/d/monthly)](https://packagist.org/packages/scn/deepl-api-connector)
[![License](https://poser.pugx.org/scn/deepl-api-connector/license)](LICENSE)
[![Build status](https://github.com/SC-Networks/deepl-api-connector/actions/workflows/php.yml/badge.svg)](https://github.com/SC-Networks/deepl-api-connector/actions/workflows/php.yml)

- Information about Deepl: https://www.deepl.com
- Deepl API Documentation: https://www.deepl.com/api.html

Requirements
============

- php (See the compatibility table below for supported php versions)
- Implementations of [PSR17 (Http-Factories)](https://www.php-fig.org/psr/psr-17/) ([Available packages](https://packagist.org/providers/psr/http-factory-implementation)) and 
[PSR18 (Http-Client)](https://www.php-fig.org/psr/psr-18/) ([Available packages](https://packagist.org/providers/psr/http-client-implementation))
- A deepl free/pro api key

Compatibility
=============

| Connector-Version               | PHP-Version(s)          |
|---------------------------------|-------------------------|
| **master** (dev)                | 8.2, 8.3                |
| **3.x** (features and bugfixes) | 7.4, 8.0, 8.1, 8.2, 8.3 |
| **2.x** (EOL)                   | 7.3, 7.4, 8.0, 8.1      |
| **1.x** (EOL)                   | 7.2, 7.3, 7.4           |

## Install

Via Composer

``` bash
$ composer require scn/deepl-api-connector
```

## Usage

### Api client creation

The `DeeplClientFactory` supports auto-detection of installed psr17/psr18 implementations.
Just call the `create` method and you are ready to go

```php
require_once __DIR__  . '/vendor/autoload.php';

use \Scn\DeeplApiConnector\DeeplClientFactory;

$deepl = DeeplClientFactory::create('your-api-key');
```

Optionally, you can provide already created instances of HttpClient, StreamFactory and RequestFactory as params to the create method.

```php
require_once __DIR__  . '/vendor/autoload.php';

use \Scn\DeeplApiConnector\DeeplClientFactory;

$deepl = DeeplClientFactory::create(
    'your-api-key',
    $existingHttpClientInstance,
    $existingStreamFactoryInstance,
    $existingRequestFactoryInstance,
);
```


If a custom HTTP client implementation is to be used, this can also be done via the DeeplClientFactory::create method.
The Client must support PSR18.


#### Get Usage of API Key

```php
require_once __DIR__  . '/vendor/autoload.php';

$deepl = \Scn\DeeplApiConnector\DeeplClientFactory::create('your-api-key');

try {
    $usageObject = $deepl->getUsage();
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
}
```

```php
require_once __DIR__  . '/vendor/autoload.php';

$deepl = \Scn\DeeplApiConnector\DeeplClientFactory::create('your-api-key');

try {
    $translation = new \Scn\DeeplApiConnector\Model\TranslationConfig(
        'My little Test',
        \Scn\DeeplApiConnector\Enum\LanguageEnum::LANGUAGE_DE
    );
    
    $translationObject = $deepl->translate('some text', \Scn\DeeplApiConnector\Enum\LanguageEnum::LANGUAGE_DE);
}
```

Optional you also can translate a batch of texts as once, see `example/translate_batch.php`

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
}
```

#### Check File Translation Status

All translation states are available in `FileStatusEnum`

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
}
```

#### Retrieve supported languages

See `example/retrieve_supported_languages.php`

#### Working with glossaries

See [use_glossaries.php](example/use_glossaries.php)

## Testing

``` bash
$ composer test
```

## Credits

- [Deepl](https://www.deepl.com)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
