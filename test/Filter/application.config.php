<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

return [
    'modules' => [
        'Laminas\Cache',
        'Laminas\Hydrator',
        'Laminas\InputFilter',
        'Laminas\Paginator',
        'Laminas\I18n',
        'Laminas\Filter',
        'Laminas\Router',
        'Laminas\Validator',
        'DoctrineModule',
        'DoctrineMongoODMModule',
        'DbMongo',
        'Laminas\ApiTools\Doctrine\ODM\QueryBuilder',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            __DIR__ . '/local.php',
        ],
        'module_paths' => [
            __DIR__ . '/../vendor',
            'DbMongo' => __DIR__ . '/../assets/module/DbMongo',
        ],
    ],
];
