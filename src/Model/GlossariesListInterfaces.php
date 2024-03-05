<?php
namespace Scn\DeeplApiConnector\Model;

interface GlossariesListInterfaces
{
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
    public function getList(): array;
}
