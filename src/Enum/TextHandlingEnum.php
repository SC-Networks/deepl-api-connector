<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Enum;

final class TextHandlingEnum
{
    public const SPLITSENTENCES_ON = '1';
    public const SPLITSENTENCES_OFF = '0';
    public const SPLITSENTENCES_NONEWLINES = 'nonewlines';

    public const PRESERVEFORMATTING_ON = '1';
    public const PRESERVEFORMATTING_OFF = '0';
}
