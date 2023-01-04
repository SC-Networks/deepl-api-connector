<?php

namespace Scn\DeeplApiConnector\Model;

use stdClass;

interface BatchTranslationInterface
{
    /**
     * @return array<array{text: string, detected_source_language: string}>
     */
    public function getTranslations(): array;

    /**
     * @param array<stdClass> $texts
     */
    public function setTranslations(array $texts): BatchTranslationInterface;
}
