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
        $this->list = $responseModel->glossaries;

        return $this;
    }

    /**
     * @return array<array{
     *  glossary_id: string,
     *  name: string,
     *  ready: boolean,
     *  source_lang: string,
     *  target_lang: string,
     *  creation_time: DateTimeImmutable,
     *  entry_count: int
     * }>
     */
    public function getList(): array
    {
        return array_map(
            fn (stdClass $item): array => (new Glossary())->hydrate($item)->getDetails(),
            $this->list
        );
    }
}
