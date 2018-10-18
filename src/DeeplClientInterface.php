<?php
declare(strict_types=1);

namespace Scn\DeeplApiConnector;

use Scn\DeeplApiConnector\Model\ResponseModelInterface;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;

/**
 * Class DeeplClientInterface
 *
 * @package Scn\DeeplApiConnector
 */
interface DeeplClientInterface
{
    public function getUsage(): ResponseModelInterface;

    public function getTranslation(TranslationConfigInterface $translation): ResponseModelInterface;

    public function translate(string $text, string $target_language): ResponseModelInterface;

    public static function create(string $apiKey): DeeplClientInterface;
}