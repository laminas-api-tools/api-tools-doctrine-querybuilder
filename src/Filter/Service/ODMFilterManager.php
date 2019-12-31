<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\Service;

use Doctrine\ODM\MongoDB\Mapping\ClassMetadata as Metadata;
use Doctrine\ODM\MongoDB\Query\Builder as QueryBuilder;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\FilterInterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception;

class ODMFilterManager extends AbstractPluginManager
{
    protected $invokableClasses = array();

    public function filter(QueryBuilder $queryBuilder, Metadata $metadata, $filters)
    {
        foreach ($filters as $option) {
            if (! isset($option['type']) or ! $option['type']) {
                // @codeCoverageIgnoreStart
                return new ApiProblem(500, 'Array element "type" is required for all filters');
            }
            // @codeCoverageIgnoreEnd

            try {
                $filter = $this->get(strtolower($option['type']), array($this));
            } catch (Exception\ServiceNotFoundException $e) {
                // @codeCoverageIgnoreStart
                return new ApiProblem(500, $e->getMessage());
            }

            // @codeCoverageIgnoreEnd
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
