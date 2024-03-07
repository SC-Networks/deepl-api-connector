<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use DateTimeImmutable;
use stdClass;

final class Glossaries extends AbstractResponseModel implements GlossariesInterface
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
            function (stdClass $item): array {
                /** @var Glossary $glossary */
                $glossary = (new Glossary())->hydrate($item);

                return $glossary->getDetails();
            },
            $this->list
        );
    }
}
