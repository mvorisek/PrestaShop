<?php

$finder = PhpCsFixer\Finder::create()->in([
    __DIR__ . '/src',
    __DIR__ . '/classes',
    __DIR__ . '/controllers',
    __DIR__ . '/tests',
    __DIR__ . '/tools/profiling',
]);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@PHP71Migration' => true,
        '@PHP71Migration:risky' => true,
        'array_indentation' => true,
        'cast_spaces' => [
            'space' => 'single',
        ],
        'combine_consecutive_issets' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'error_suppression' => [
            'mute_deprecation_error' => false,
            'noise_remaining_usages' => false,
            'noise_remaining_usages_exclude' => [],
        ],
        'function_to_constant' => false,
        'method_chaining_indentation' => true,
        'no_alias_functions' => false,
        'no_superfluous_phpdoc_tags' => false,
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'phpdoc_summary' => false,
        'protected_to_private' => false,
        'psr_autoloading' => false,
        'self_accessor' => false,
        'yoda_style' => null,
        'single_line_throw' => false,
        'no_alias_language_construct_call' => false,
        'use_arrow_functions' => false,
        'declare_strict_types' => false,
        'random_api_migration' => false,
        'void_return' => false,
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/var/.php_cs.cache');
