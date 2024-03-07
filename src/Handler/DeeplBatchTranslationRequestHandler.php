<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Model\BatchTranslationConfigInterface;

/**
 * Builds the request body for batch translations
 */
final class DeeplBatchTranslationRequestHandler extends AbstractDeeplHandler
{
    private const SEPARATOR = ',';
    public const API_ENDPOINT = '/v2/translate';

    private string $authKey;

    private StreamFactoryInterface $streamFactory;

    private BatchTranslationConfigInterface $translation;

    public function __construct(
        string $authKey,
        StreamFactoryInterface $streamFactory,
        BatchTranslationConfigInterface $translation
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
        $query = http_build_query(
            array_filter(
                [
                    'target_lang' => $this->translation->getTargetLang(),
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
                    'glossary_id' => $this->translation->getGlossaryId(),
                    'auth_key' => $this->authKey,
                ]
            )
        );

        // add the text parameters separately as http_build_query would create `text[]` params
        foreach ($this->translation->getText() as $text) {
            $query .= '&text=' . $text;
        }

        return $this->streamFactory->createStream($query);
    }

    public function getContentType(): string
    {
        return 'application/x-www-form-urlencoded';
    }
}
