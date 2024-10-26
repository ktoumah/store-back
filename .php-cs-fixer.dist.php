<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['vendor', 'public', 'var', 'config', 'bin', 'translations', 'src/Infrastructure/Persistence/Migrations', 'tests', 'src/Infrastructure/Persistence/Fixture', 'src/Infrastructure/Persistence/Entity']);

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'method_argument_space' => false,
        'braces_position' => false,
        'no_extra_blank_lines' => false,
        'type_declaration_spaces' => false,
        'control_structure_braces' => false,
        'statement_indentation' => false,
        'function_declaration' => false,
        'multiline_whitespace_before_semicolons' => true,
        'php_unit_internal_class' => true,
        'php_unit_test_class_requires_covers' => true,
        'no_superfluous_phpdoc_tags' => ["allow_mixed" => true, "allow_unused_params" => true],
        '@DoctrineAnnotation' => true,
        'yoda_style' => false,
        'single_quote' => false,
        'global_namespace_import' => ['import_classes' => true, 'import_constants' => true, 'import_functions' => true],
        'concat_space' => ["spacing" => "one"],
        'no_unused_imports' => true,
        'phpdoc_var_without_name' => false,
        'increment_style' => ['style' => 'post'],
    ])
    ->setFinder($finder);
