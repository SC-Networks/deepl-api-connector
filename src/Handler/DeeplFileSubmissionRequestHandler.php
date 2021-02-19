<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;

final class DeeplFileSubmissionRequestHandler implements DeeplRequestHandlerInterface
{
    public const API_ENDPOINT = 'https://api.deepl.com/v2/document';

    private $authKey;

    private $fileTranslation;

    private $multipartStreamBuilder;

    public function __construct(
        string $authKey,
        FileTranslationConfigInterface $fileTranslation,
        MultipartStreamBuilder $multipartStreamBuilder
    ) {
        $this->authKey = $authKey;
        $this->fileTranslation = $fileTranslation;
        $this->multipartStreamBuilder = $multipartStreamBuilder;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_POST;
    }

    public function getPath(): string
    {
        return static::API_ENDPOINT;
    }

    public function getBody(): StreamInterface
    {
        return $this->multipartStreamBuilder
            ->setBoundary('boundary')
            ->addResource('auth_key', $this->authKey)
            ->addResource('file', $this->fileTranslation->getFileContent())
            ->addResource('filename', $this->fileTranslation->getFileName())
            ->addResource('source_lang', $this->fileTranslation->getSourceLang())
            ->addResource('target_lang', $this->fileTranslation->getTargetLang())
            ->build();
    }

    public function getContentType(): string
    {
        return 'multipart/form-data;boundary="boundary"';
    }
}
