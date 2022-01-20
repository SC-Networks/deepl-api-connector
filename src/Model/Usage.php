<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

final class Usage extends AbstractResponseModel implements UsageInterface
{
    private int $characterCount;

    private int $characterLimit;

    public function getCharacterCount(): int
    {
        return $this->characterCount;
    }

    public function setCharacterCount(int $characterCount): UsageInterface
    {
        $this->characterCount = $characterCount;

        return $this;
    }

    public function getCharacterLimit(): int
    {
        return $this->characterLimit;
    }

    public function setCharacterLimit(int $characterLimit): UsageInterface
    {
        $this->characterLimit = $characterLimit;

        return $this;
    }
}
