<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use stdClass;

final class BatchTranslation extends AbstractResponseModel implements BatchTranslationInterface
{
    /** @var array<stdClass> */
    private array $translations = [];

    public function hydrate(stdClass $responseModel): ResponseModelInterface
    {
        $this->translations = $responseModel->translations;

        return $this;
    }

    public function getTranslations(): array
    {
        return array_map(
            fn (stdClass $item): array => [
                'text' => (string) $item->text,
                'detected_source_language' => (string) $item->detected_source_language,
            ],
            $this->translations
        );
    }

    public function setTranslations(array $texts): BatchTranslationInterface
    {
        $this->translations = $texts;

        return $this;
    }
}
