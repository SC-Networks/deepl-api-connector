<?php
namespace Scn\DeeplApiConnector\Model;

interface GlossariesSupportedLanguagesPairsInterface
{
    /**
     * @return array<array{
     *  source_lang: string,
     *  target_lang: string
     * }>
     */
    public function getList(): array;
}
