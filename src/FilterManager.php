<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\ODM\QueryBuilder;

use Doctrine\ODM\MongoDB\Mapping\ClassMetadata as Metadata;
use Doctrine\ODM\MongoDB\Query\Builder as QueryBuilder;
use Laminas\ApiTools\Doctrine\ODM\QueryBuilder\Filter\FilterInterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception;
use RuntimeException;

class FilterManager extends AbstractPluginManager
{
    /**
     * @var string
     */
    protected $instanceOf = FilterInterface::class;

    public function filter(QueryBuilder $queryBuilder, Metadata $metadata, $filters)
    {
        foreach ($filters as $option) {
            if (empty($option['type'])) {
                throw new RuntimeException('Array element "type" is required for all filters');
            }

            $filter = $this->get(strtolower($option['type']), [$this]);
            $filter->filter($queryBuilder, $metadata, $option);
        }
    }

    /**
     * Validate the plugin is of the expected type (v3).
     *
     * Validates against `$instanceOf`.
     *
     * @param mixed $instance
     * @return void
     * @throws Exception\InvalidServiceException
     */
    public function validate($instance)
    {
        if (! $instance instanceof $this->instanceOf) {
            throw new Exception\InvalidServiceException(sprintf(
                '%s can only create instances of %s; %s is invalid',
                get_class($this),
                $this->instanceOf,
                is_object($instance) ? get_class($instance) : gettype($instance)
            ));
        }
    }

    /**
     * Validate the plugin is of the expected type (v2).
     *
     * Proxies to `validate()`.
     *
     * @param mixed $instance
     * @return void
     * @throws Exception\InvalidArgumentException
     */
    public function validatePlugin($instance)
    {
        try {
            $this->validate($instance);
        } catch (Exception\InvalidServiceException $e) {
            throw new Exception\InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
