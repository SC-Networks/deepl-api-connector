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

    private StreamFactoryInterface $streamFactory;

    private BatchTranslationConfigInterface $translation;

    public function __construct(
        StreamFactoryInterface $streamFactory,
        BatchTranslationConfigInterface $translation,
    ) {
        $this->streamFactory = $streamFactory;
        $this->translation = $translation;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_POST;
    }

    public function getPath(): string
    {
        return self::API_ENDPOINT;
    }

    public function getBody(): StreamInterface
    {
        $body = array_filter([
            'target_lang' => $this->translation->getTargetLang(),
            'tag_handling' => implode(
                self::SEPARATOR,
                $this->translation->getTagHandling(),
            ),
            'non_splitting_tags' => implode(
                self::SEPARATOR,
                $this->translation->getNonSplittingTags(),
            ),
            'ignore_tags' => implode(self::SEPARATOR, $this->translation->getIgnoreTags()),
            'split_sentences' => $this->translation->getSplitSentences(),
            'preserve_formatting' => $this->translation->getPreserveFormatting(),
            'glossary_id' => $this->translation->getGlossaryId(),
            'text' => [],
        ]);

        // add the text parameters separately as http_build_query would create `text[]` params
        foreach ($this->translation->getText() as $text) {
            $body['text'][] = $text;
        }

        return $this->streamFactory->createStream(json_encode($body, JSON_THROW_ON_ERROR));
    }
}
