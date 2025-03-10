<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config()) // Changed here
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder(
        Finder::create()
            ->in(__DIR__)
            ->exclude('vendor')
    );
