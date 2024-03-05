<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use DateTimeImmutable;
use stdClass;

final class GlossariesList extends AbstractResponseModel implements GlossariesListInterface
{
    /** @var array<stdClass> */
    private array $list;

    public function hydrate(stdClass $responseModel): ResponseModelInterface
    {
        $this->list = $responseModel->content->supported_languages;

        return $this;
    }

    public function getList(): array
    {
        return array_map(
            fn (stdClass $item): array => [
                'glossary_id' => $item->glossary_id,
                'name' => $item->name,
                'ready' => $item->ready,
                'source_lang' => $item->source_lang,
                'target_lang' => $item->target_lang,
                'creation_time' => new DateTimeImmutable($item->creation_time),
                'entry_count' => $item->entry_count,
            ],
            $this->list
        );
    }
}
