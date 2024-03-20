<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector;
use Rector\ValueObject\PhpVersion;
use Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\If_\ShortenElseIfRector;
use Rector\CodeQuality\Rector\Identical\SimplifyConditionsRector;
use Rector\CodeQuality\Rector\BooleanNot\SimplifyDeMorganBinaryRector;
use Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfNotNullReturnRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfNullableReturnRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyInArrayValuesRector;
use Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector;
use Rector\CodeQuality\Rector\Ternary\TernaryEmptyArrayArrayDimFetchToCoalesceRector;
use Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use Rector\CodingStyle\Rector\If_\NullableCompareToNullRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withPhpVersion(PhpVersion::PHP_70)
    ->withImportNames(importShortClasses: false)
    ->withPhpSets(php70: true)
    ->withRules([
        ConsecutiveNullCompareReturnsToNullCoalesceQueueRector::class,
        ExplicitBoolCompareRector::class,
        FlipTypeControlToUseExclusiveTypeRector::class,
        ForRepeatedCountToOwnVariableRector::class,
        InlineConstructorDefaultToPropertyRector::class,
        ShortenElseIfRector::class,
        SimplifyConditionsRector::class,
        SimplifyDeMorganBinaryRector::class,
        SimplifyEmptyCheckOnEmptyArrayRector::class,
        SimplifyForeachToCoalescingRector::class,
        SimplifyIfElseToTernaryRector::class,
        SimplifyIfNotNullReturnRector::class,
        SimplifyIfNullableReturnRector::class,
        SimplifyInArrayValuesRector::class,
        SimplifyUselessVariableRector::class,
        TernaryEmptyArrayArrayDimFetchToCoalesceRector::class,
        ThrowWithPreviousExceptionRector::class,
        UseIdenticalOverEqualWithSameTypeRector::class,
        CountArrayToEmptyArrayComparisonRector::class,
        NullableCompareToNullRector::class,
        SymplifyQuoteEscapeRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
        PrivatizeFinalClassMethodRector::class,
        PrivatizeFinalClassPropertyRector::class,
        ArgumentRemoverRector::class
    ])
    ->withPreparedSets(deadCode: true, earlyReturn: true, instanceOf: true, strictBooleans: true, typeDeclarations: true);
