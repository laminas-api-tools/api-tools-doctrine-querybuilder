<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

return array(
    'service_manager' => array(
        'factories' => array(
            'LaminasDoctrineQueryBuilderFilterManagerOrm' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\Service\ORMFilterManagerFactory',
            'LaminasDoctrineQueryBuilderFilterManagerOdm' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\Service\ODMFilterManagerFactory',
            'LaminasDoctrineQueryBuilderOrderByManagerOrm' => 'Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\Service\ORMOrderByManagerFactory',
            'LaminasDoctrineQueryBuilderOrderByManagerOdm' => 'Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\Service\ODMOrderByManagerFactory',
        ),
    ),
);
