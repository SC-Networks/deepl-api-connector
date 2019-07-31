<?php declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;

final class DeeplFileSubmissionRequestHandler implements DeeplRequestHandlerInterface
{
    const API_ENDPOINT = 'https://api.deepl.com/v2/document';

    private $authKey;

    private $fileTranslation;

    public function __construct(string $authKey, FileTranslationConfigInterface $fileTranslation)
    {
        $this->authKey = $authKey;
        $this->fileTranslation = $fileTranslation;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_POST;
    }

    public function getPath(): string
    {
        return static::API_ENDPOINT;
    }

    public function getBody(): array
    {
        return [
            'multipart' => [
                [
                    'name' => 'auth_key',
                    'contents' => $this->authKey
                ],
                [
                    'name' => 'file',
                    'filename' => $this->fileTranslation->getFileName(),
                    'contents' => $this->fileTranslation->getFileContent()
                ],
                [
                    'name' => 'filename',
                    'contents' => $this->fileTranslation->getFileName()
                ],
                [
                    'name' => 'source_lang',
                    'contents' => $this->fileTranslation->getSourceLang()
                ],
                [
                    'name' => 'target_lang',
                    'contents' => $this->fileTranslation->getTargetLang()
                ],
            ]
        ];
    }
}
