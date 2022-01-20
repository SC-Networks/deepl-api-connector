<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

final class DeeplTranslationRequestHandler implements DeeplRequestHandlerInterface
{
    private const SEPARATOR = ',';
    public const API_ENDPOINT = '/v2/translate';

    private string $authKey;

    private StreamFactoryInterface $streamFactory;

    private TranslationConfigInterface $translation;

    public function __construct(
        string $authKey,
        StreamFactoryInterface $streamFactory,
        TranslationConfigInterface $translation
    ) {
        $this->authKey = $authKey;
        $this->streamFactory = $streamFactory;
        $this->translation = $translation;
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
        return $this->streamFactory->createStream(
            http_build_query(
                array_filter(
                    [
                        'text' => $this->translation->getText(),
                        'target_lang' => $this->translation->getTargetLang(),
                        'source_lang' => $this->translation->getSourceLang(),
                        'tag_handling' => implode(
                            static::SEPARATOR,
                            $this->translation->getTagHandling()
                        ),
                        'non_splitting_tags' => implode(
                            static::SEPARATOR,
                            $this->translation->getNonSplittingTags()
                        ),
                        'ignore_tags' => implode(static::SEPARATOR, $this->translation->getIgnoreTags()),
                        'split_sentences' => $this->translation->getSplitSentences(),
                        'preserve_formatting' => $this->translation->getPreserveFormatting(),
                        'auth_key' => $this->authKey,
                    ]
                )
            )
        );
    }

    public function getContentType(): string
    {
        return 'application/x-www-form-urlencoded';
    }
}
