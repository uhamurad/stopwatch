<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withImportNames(importShortClasses: false)
    ->withPhpSets(php70: true);
