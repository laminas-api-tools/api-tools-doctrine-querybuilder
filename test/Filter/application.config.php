<?php

return [
    'modules'                 => [
        'DoctrineModule',
        'DoctrineORMModule',
        'DoctrineMongoODMModule',
        'Db',
        'DbMongo',
        'Laminas\ApiTools\Doctrine\QueryBuilder',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            __DIR__ . '/local.php',
        ],
        'module_paths'      => [
            __DIR__ . '/../vendor',
            'DbMongo'                                => __DIR__ . '/../assets/module/DbMongo',
            'Db'                                     => __DIR__ . '/../assets/module/Db',
            'Laminas\ApiTools\Doctrine\QueryBuilder' => __DIR__ . '/../../',
        ],
    ],
];
