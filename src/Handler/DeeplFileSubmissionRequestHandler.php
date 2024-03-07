<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;

final class DeeplFileSubmissionRequestHandler extends AbstractDeeplHandler
{
    public const API_ENDPOINT = '/v2/document';

    private string $authKey;

    private FileTranslationConfigInterface $fileTranslation;

    private MultipartStreamBuilder $multipartStreamBuilder;

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
        $streamBuilder = $this->multipartStreamBuilder
            ->setBoundary('boundary')
            ->addResource('auth_key', $this->authKey)
            ->addResource('file', $this->fileTranslation->getFileContent(), ['filename' => $this->fileTranslation->getFileName()])
            ->addResource('target_lang', $this->fileTranslation->getTargetLang());

        // add sourceLanguage only if set, otherwise the file won't be translated #26
        $sourceLanguage = $this->fileTranslation->getSourceLang();
        if ($sourceLanguage !== '') {
            $streamBuilder = $streamBuilder->addResource('source_lang', $sourceLanguage);
        }

        return $streamBuilder->build();
    }

    public function getContentType(): string
    {
        return 'multipart/form-data;boundary="boundary"';
    }
}
