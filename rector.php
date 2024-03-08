<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector;
use Rector\PHPUnit\PHPUnit100\Rector\Class_\StaticDataProviderClassMethodRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withPreparedSets(deadCode: true, codeQuality: true)
    ->withRules([
        AddLiteralSeparatorToNumberRector::class,
        ClosureToArrowFunctionRector::class,
        AssertSameTrueFalseToAssertTrueFalseRector::class,
        StaticDataProviderClassMethodRector::class,
        AddVoidReturnTypeWhereNoReturnRector::class,
    ]);
