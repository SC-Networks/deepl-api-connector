<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

return (new Config())
    ->setRules([
        '@PSR2' => true,
        'no_unused_imports' => true,
    ])
    ->setFinder($finder);
