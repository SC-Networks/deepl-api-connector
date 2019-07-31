<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Enum;

final class FileStatusEnum
{
    public const FILE_TRANSLATION_DONE = 'done';
    public const FILE_TRANSLATION_QUEUED = 'queued';
    public const FILE_TRANSLATION_TRANSLATING = 'translating';
    public const FILE_TRANSLATION_ERROR = 'error';
}
