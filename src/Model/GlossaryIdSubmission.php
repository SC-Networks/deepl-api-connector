<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

class GlossaryIdSubmission implements GlossaryIdSubmissionInterface
{
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): GlossaryIdSubmission
    {
        $this->id = $id;

        return $this;
    }
}
