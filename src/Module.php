<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder;

use ArrayAccess;
use Laminas\ModuleManager\Feature\DependencyIndicatorInterface;
use Laminas\ModuleManager\Listener\ServiceListener;
use Laminas\ModuleManager\ModuleManager;

class Module implements DependencyIndicatorInterface
{
    /**
     * @return array|ArrayAccess
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function init(ModuleManager $moduleManager)
    {
        $serviceManager = $moduleManager->getEvent()->getParam('ServiceManager');
        /** @var ServiceListener $serviceListener */
        $serviceListener = $serviceManager->get('ServiceListener');

        $serviceListener->addServiceManager(
            'LaminasDoctrineQueryBuilderFilterManagerOrm',
            'api-tools-doctrine-querybuilder-filter-orm',
            Filter\FilterInterface::class,
            'getDoctrineQueryBuilderFilterOrmConfig'
        );

        $serviceListener->addServiceManager(
            'LaminasDoctrineQueryBuilderFilterManagerOdm',
            'api-tools-doctrine-querybuilder-filter-odm',
            Filter\FilterInterface::class,
            'getDoctrineQueryBuilderFilterOdmConfig'
        );

        $serviceListener->addServiceManager(
            'LaminasDoctrineQueryBuilderOrderByManagerOrm',
            'api-tools-doctrine-querybuilder-orderby-orm',
            OrderBy\OrderByInterface::class,
            'getDoctrineQueryBuilderOrderByOrmConfig'
        );
        $serviceListener->addServiceManager(
            'LaminasDoctrineQueryBuilderOrderByManagerOdm',
            'api-tools-doctrine-querybuilder-orderby-odm',
            OrderBy\OrderByInterface::class,
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
        return ['DoctrineModule'];
    }
}
