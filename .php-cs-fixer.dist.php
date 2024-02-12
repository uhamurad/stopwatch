<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'visibility_required' => ['elements' => ['method', 'property']],
        'declare_strict_types' => true,
        'no_unused_imports' => true,
    ])
    ->setFinder($finder)
    ;