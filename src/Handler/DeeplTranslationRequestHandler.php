<?php

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

    /**
     * @var string
     */
    private $authKey;

    /**
     * @var TranslationConfigInterface
     */
    private $translation;

    /**
     * DeeplTranslationRequestHandler constructor.
     *
     * @param string $authKey
     * @param TranslationConfigInterface $translation
     */
    public function __construct($authKey, TranslationConfigInterface $translation)
    {
        $this->authKey = $authKey;
        $this->translation = $translation;
    }

    /**
     *
     * @return string
     */
    public function getMethod()
    {
        return DeeplRequestHandlerInterface::METHOD_POST;
    }

    /**
     *
     * @return string
     */
    public function getPath()
    {
        return static::API_ENDPOINT;
    }

    /**
     *
     * @return array
     */
    public function getBody()
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