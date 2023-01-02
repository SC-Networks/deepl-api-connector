<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use stdClass;

final class SupportedLanguages extends AbstractResponseModel implements SupportedLanguagesInterfaces
{
    /** @var array<stdClass> */
    private array $languages;

    public function hydrate(stdClass $responseModel): ResponseModelInterface
    {
        $this->languages = $responseModel->content;

        return $this;
    }

    /**
     * @return array<array{
     *  language_code: string,
     *  name: string,
     *  supports_formality: bool
     * }>
     */
    public function getLanguages(): array
    {
        return array_map(
            fn (stdClass $item): array => [
                'language_code' => $item->language,
                'name' => $item->name,
                'supports_formality' => $item->supports_formality,
            ],
            $this->languages
        );
    }
}
