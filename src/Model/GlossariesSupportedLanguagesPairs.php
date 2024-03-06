<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use stdClass;

final class GlossariesSupportedLanguagesPairs extends AbstractResponseModel implements GlossariesSupportedLanguagesPairsInterface
{
    /** @var array<stdClass> */
    private array $list;

    public function hydrate(stdClass $responseModel): ResponseModelInterface
    {
        $this->list = $responseModel->supported_languages;

        return $this;
    }

    /**
     * @return array<array{
     *  source_lang: string,
     *  target_lang: string
     * }>
     */
    public function getList(): array
    {
        return array_map(
            fn (stdClass $item): array => [
                'source_lang' => $item->source_lang,
                'target_lang' => $item->target_lang,
            ],
            $this->list
        );
    }
}
