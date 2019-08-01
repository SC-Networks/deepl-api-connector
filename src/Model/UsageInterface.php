<?php

namespace Scn\DeeplApiConnector\Model;

interface UsageInterface
{
    public function getCharacterCount(): int;

    public function setCharacterCount(int $characterCount): UsageInterface;

    public function getCharacterLimit(): int;

    public function setCharacterLimit(int $characterLimit): UsageInterface;
}
