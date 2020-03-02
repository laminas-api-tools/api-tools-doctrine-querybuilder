<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\ODM\QueryBuilder;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\DependencyIndicatorInterface;

class Module implements
    ConfigProviderInterface,
    DependencyIndicatorInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Expected to return an array of modules on which the current one depends on
     *
     * @return array
     */
    public function getModuleDependencies()
    {
        return ['DoctrineMongoODMModule'];
    }
}
