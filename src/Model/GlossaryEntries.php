<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use stdClass;

final class GlossaryEntries extends AbstractResponseModel implements GlossaryEntriesInterface
{
    private string $result;

    public function hydrate(stdClass $responseModel): ResponseModelInterface
    {
        $this->result = $responseModel->content;

        return $this;
    }

    public function getList(): array
    {
        return array_map(
            fn (string $item): array => [
                'source' => explode("\t", $item)[0] ?? '',
                'target' => explode("\t", $item)[1] ?? '',
            ],
            explode("\n", $this->result)
        );
    }

    public function getResult(): string
    {
        return $this->result;
    }
}
