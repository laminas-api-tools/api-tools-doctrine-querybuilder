<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\Doctrine\ORM\QueryBuilder\Filter;

return [
    'modules' => [
        'DoctrineModule',
        'DoctrineORMModule',
        'Db',
        'Laminas\ApiTools\Doctrine\ORM\QueryBuilder',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            __DIR__ . '/local.php',
        ],
        'module_paths' => [
            __DIR__ . '/../vendor',
            'Db' => __DIR__ . '/../assets/module/Db',
            'Laminas\ApiTools\Doctrine\ORM\QueryBuilder' => __DIR__ . '/../../src',
        ],
    ],
];
