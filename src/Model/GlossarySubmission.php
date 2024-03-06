<?php

namespace Scn\DeeplApiConnector\Model;

use Scn\DeeplApiConnector\Enum\GlossarySubmissionEntryFormatEnum;

class GlossarySubmission implements GlossarySubmissionInterface
{
    private string $name;
    private string $sourceLang;
    private string $targetLang;
    private string $entries;
    private string $entriesFormat = GlossarySubmissionEntryFormatEnum::FORMAT_TSV;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): GlossarySubmission
    {
        $this->name = $name;

        return $this;
    }

    public function getSourceLang(): string
    {
        return $this->sourceLang;
    }

    public function setSourceLang(string $sourceLang): GlossarySubmission
    {
        $this->sourceLang = $sourceLang;

        return $this;
    }

    public function getTargetLang(): string
    {
        return $this->targetLang;
    }

    public function setTargetLang(string $targetLang): GlossarySubmission
    {
        $this->targetLang = $targetLang;

        return $this;
    }

    public function getEntries(): string
    {
        return $this->entries;
    }

    public function setEntries(string $entries): GlossarySubmission
    {
        $this->entries = $entries;

        return $this;
    }

    public function getEntriesFormat(): string
    {
        return $this->entriesFormat;
    }

    public function setEntriesFormat(string $entriesFormat): GlossarySubmission
    {
        $this->entriesFormat = $entriesFormat;

        return $this;
    }

    /**
     * @return array{
     *  name: string,
     *  source_lang: string,
     *  target_lang: string,
     *  entries: string,
     *  entries_format: string,
     * }
     */
    public function toArrayRequest(): array
    {
        return [
            'name' => $this->getName(),
            'source_lang' => $this->getSourceLang(),
            'target_lang' => $this->getTargetLang(),
            'entries' => $this->getEntries(),
            'entries_format' => $this->getEntriesFormat(),
        ];
    }
}
