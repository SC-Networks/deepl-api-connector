<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

/**
 * Interface UsageInterface
 *
 * @package Scn\DeeplApiConnector\Model
 */
interface UsageInterface
{
    public function getCharacterCount(): int;

    public function setCharacterCount(int $characterCount): UsageInterface;

    public function getCharacterLimit(): int;

    public function setCharacterLimit(int $characterLimit): UsageInterface;
}