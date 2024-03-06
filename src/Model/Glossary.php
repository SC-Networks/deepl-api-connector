<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use DateTimeImmutable;
use stdClass;

final class Glossary extends AbstractResponseModel implements GlossaryInterface
{
    private stdClass $details;

    public function hydrate(stdClass $responseModel): ResponseModelInterface
    {
        $this->details = $responseModel;

        return $this;
    }

    /**
     * @return array{
     *  glossary_id: string,
     *  name: string,
     *  ready: boolean,
     *  source_lang: string,
     *  target_lang: string,
     *  creation_time: DateTimeImmutable,
     *  entry_count: int
     * }
     */
    public function getDetails(): array
    {
        return [
            'glossary_id' => $this->details->glossary_id,
            'ready' => $this->details->ready,
            'name' => $this->details->name,
            'source_lang' => $this->details->source_lang,
            'target_lang' => $this->details->target_lang,
            'creation_time' => $this->details->creation_time,
            'entry_count' => $this->details->entry_count,
        ];
    }
}
