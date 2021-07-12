<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\Service;

use Laminas\Mvc\Service\AbstractPluginManagerFactory;

class ORMFilterManagerFactory extends AbstractPluginManagerFactory
{
    public const PLUGIN_MANAGER_CLASS = ORMFilterManager::class;
}
