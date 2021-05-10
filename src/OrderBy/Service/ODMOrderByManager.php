<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\Service;

use Doctrine\ODM\MongoDB\Query\Builder as QueryBuilder;
use Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\OrderByInterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception;
use RuntimeException;

use function get_class;
use function gettype;
use function is_object;
use function sprintf;
use function strtolower;

class ODMOrderByManager extends AbstractPluginManager
{
    /** @var string */
    protected $instanceOf = OrderByInterface::class;

    /**
     * @param object $metadata
     * @param iterable $orderBy
     * @return void
     */
    public function orderBy(QueryBuilder $queryBuilder, $metadata, $orderBy)
    {
        foreach ($orderBy as $option) {
            if (empty($option['type'])) {
                throw new RuntimeException('Array element "type" is required for all orderby directives');
            }

            $orderByHandler = $this->get(strtolower($option['type']), [$this]);
            $orderByHandler->orderBy($queryBuilder, $metadata, $option);
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
                static::class,
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
