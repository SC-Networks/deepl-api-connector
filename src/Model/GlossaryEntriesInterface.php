<?php

namespace Scn\DeeplApiConnector\Model;

interface GlossaryEntriesInterface
{
    /**
     * @return array<array{
     *  source: string,
     *  target: string
     * }>
     */
    public function getList(): array;

    public function getResult(): string;
}
