<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder;

use Laminas\ModuleManager\Feature\DependencyIndicatorInterface;
use Laminas\ModuleManager\ModuleManager;

class Module implements DependencyIndicatorInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Laminas\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/',
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/server.config.php';
    }

    public function init(ModuleManager $moduleManager)
    {
        $serviceManager  = $moduleManager->getEvent()->getParam('ServiceManager');
        $serviceListener = $serviceManager->get('ServiceListener');

        $serviceListener->addServiceManager(
            'LaminasDoctrineQueryBuilderFilterManagerOrm',
            'api-tools-doctrine-querybuilder-filter-orm',
            'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\FilterInterface',
            'getDoctrineQueryBuilderFilterOrmConfig'
        );

        $serviceListener->addServiceManager(
            'LaminasDoctrineQueryBuilderFilterManagerOdm',
            'api-tools-doctrine-querybuilder-filter-odm',
            'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\FilterInterface',
            'getDoctrineQueryBuilderFilterOdmConfig'
        );

        $serviceListener->addServiceManager(
            'LaminasDoctrineQueryBuilderOrderByManagerOrm',
            'api-tools-doctrine-querybuilder-orderby-orm',
            'Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\OrderByInterface',
            'getDoctrineQueryBuilderOrderByOrmConfig'
        );
        $serviceListener->addServiceManager(
            'LaminasDoctrineQueryBuilderOrderByManagerOdm',
            'api-tools-doctrine-querybuilder-orderby-odm',
            'Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\OrderByInterface',
            'getDoctrineQueryBuilderOrderByOdmConfig'
        );
    }

    /**
     * Expected to return an array of modules on which the current one depends on
     *
     * @return array
     */
    public function getModuleDependencies()
    {
        return array('DoctrineModule');
    }
}
