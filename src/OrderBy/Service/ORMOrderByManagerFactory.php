<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\Service;

use Laminas\Mvc\Service\AbstractPluginManagerFactory;

class ORMOrderByManagerFactory extends AbstractPluginManagerFactory
{
    public const PLUGIN_MANAGER_CLASS = ORMOrderByManager::class;
}
