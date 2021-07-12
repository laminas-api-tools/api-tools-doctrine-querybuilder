<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\Service;

use Laminas\Mvc\Service\AbstractPluginManagerFactory;

class ODMOrderByManagerFactory extends AbstractPluginManagerFactory
{
    public const PLUGIN_MANAGER_CLASS = ODMOrderByManager::class;
}
