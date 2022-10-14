<?php

$config = new PhpCsFixer\Config();
$config->getFinder()
    ->exclude('vendor')
    ->in(__DIR__);
$config->setRules([
    '@PSR2' => true,
    'no_unused_imports' => true,
]);
return $config;
