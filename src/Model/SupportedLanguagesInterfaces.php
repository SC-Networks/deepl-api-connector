<?php
namespace Scn\DeeplApiConnector\Model;

interface SupportedLanguagesInterfaces
{
    /**
     * @return array<array{
     *  language_code: string,
     *  name: string,
     *  supports_formality: bool
     * }>
     */
    public function getLanguages(): array;
}
