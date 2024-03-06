<?php

namespace Scn\DeeplApiConnector\Model;

interface GlossarySubmissionInterface
{
    public function getName(): string;

    public function setName(string $name): GlossarySubmissionInterface;

    public function getSourceLang(): string;

    public function setSourceLang(string $sourceLang): GlossarySubmissionInterface;

    public function getTargetLang(): string;

    public function setTargetLang(string $targetLang): GlossarySubmissionInterface;

    public function getEntries(): string;

    public function setEntries(string $entries): GlossarySubmissionInterface;

    public function getEntriesFormat(): string;

    public function setEntriesFormat(string $entriesFormat): GlossarySubmissionInterface;

    /**
     * @return array{
     *  name: string,
     *  source_lang: string,
     *  target_lang: string,
     *  entries: string,
     *  entries_format: string,
     * }
     */
    public function toArrayRequest(): array;
}
