<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

/**
 * Class TranslationRequestHandlerHandler
 *
 * @package Scn\DeeplApiConnector\Handler
 */
final class DeeplTranslationRequestHandler implements DeeplRequestHandlerInterface
{

    const SEPARATOR = ',';
    const API_ENDPOINT = 'https://api.deepl.com/v1/translate';

    private $authKey;

    private $translation;

    public function __construct(string $authKey, TranslationConfigInterface $translation)
    {
        $this->authKey = $authKey;
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

    public function getBody(): array
    {
        return [
            'form_params' => array_filter(
                [
                    'text' => $this->translation->getText(),
                    'target_lang' => $this->translation->getTargetLang(),
                    'source_lang' => $this->translation->getSourceLang(),
                    'tag_handling' => implode(static::SEPARATOR,
                        (array)$this->translation->getTagHandling()),
                    'non_splitting_tags' => implode(static::SEPARATOR,
                        (array)$this->translation->getNonSplittingTags()),
                    'ignore_tags' => implode(static::SEPARATOR, (array)$this->translation->getIgnoreTags()),
                    'split_sentences' => (string)$this->translation->getSplitSentences(),
                    'preserve_formatting' => $this->translation->getPreserveFormatting(),
                    'auth_key' => $this->authKey,
                ]
            )
        ];
    }
}