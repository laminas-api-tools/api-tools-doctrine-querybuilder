<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\ORM\QueryBuilder;

use Laminas\ModuleManager\Feature\DependencyIndicatorInterface;
use Laminas\ModuleManager\Listener\ServiceListener;
use Laminas\ModuleManager\ModuleManager;

class Module implements DependencyIndicatorInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function init(ModuleManager $moduleManager)
    {
        $serviceManager  = $moduleManager->getEvent()->getParam('ServiceManager');
        /** @var ServiceListener $serviceListener */
        $serviceListener = $serviceManager->get('ServiceListener');

        $serviceListener->addServiceManager(
            FilterManager::class,
            'api-tools-doctrine-orm-querybuilder-filter',
            Filter\AbstractFilter::class,
            'getDoctrineOrmQueryBuilderFilterConfig'
        );

        $serviceListener->addServiceManager(
            OrderByManager::class,
            'api-tools-doctrine-orm-querybuilder-orderby',
            OrderBy\AbstractOrderBy::class,
            'getDoctrineQueryBuilderOrmOrderByConfig'
        );
    }

    /**
     * Expected to return an array of modules on which the current one depends on
     *
     * @return string[]
     */
    public function getModuleDependencies()
    {
        return ['DoctrineORMModule'];
    }
}
