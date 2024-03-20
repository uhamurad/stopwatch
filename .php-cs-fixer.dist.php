<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@PER-CS2.0' => true,
        'visibility_required' => ['elements' => ['method', 'property']],
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'ordered_class_elements' =>  ['order' => ['use_trait', 'case', 'constant_public', 'constant_protected', 'constant_private', 'property_public', 'property_protected', 'property_private', 'construct', 'destruct', 'magic', 'phpunit', 'method_public', 'method_protected', 'method_private']],
    ])
    ->setFinder($finder)
    ;