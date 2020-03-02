<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\ORM\QueryBuilder;

use Laminas\ModuleManager\Feature\DependencyIndicatorInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements
    ConfigProviderInterface,
    DependencyIndicatorInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Return an array of modules on which this depends on
     *
     * @return string[]
     */
    public function getModuleDependencies()
    {
        return ['DoctrineORMModule'];
    }
}
