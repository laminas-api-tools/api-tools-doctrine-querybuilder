<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\Service;

use Doctrine\ORM\QueryBuilder;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\FilterInterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception;

class ORMFilterManager extends AbstractPluginManager
{
    protected $invokableClasses = array();

    public function filter(QueryBuilder $queryBuilder, $metadata, $filters)
    {
        foreach ($filters as $option) {
            if (! isset($option['type']) or ! $option['type']) {
                // @codeCoverageIgnoreStart
                throw new Exception\RuntimeException('Array element "type" is required for all filters');
            }
            // @codeCoverageIgnoreEnd

            $filter = $this->get(strtolower($option['type']), array($this));

            $filter->filter($queryBuilder, $metadata, $option);
        }
    }

    /**
     * @param mixed $filter
     *
     * @return void
     * @throws Exception\RuntimeException
     */
    public function validatePlugin($filter)
    {
        if ($filter instanceof FilterInterface) {
            // we're okay
            return;
        }

        // @codeCoverageIgnoreStart
        throw new Exception\RuntimeException(sprintf(
            'Plugin of type %s is invalid; must implement %s\Plugin\PluginInterface',
            (is_object($filter) ? get_class($filter) : gettype($filter)),
            __NAMESPACE__
        ));
        // @codeCoverageIgnoreEnd
    }
}
