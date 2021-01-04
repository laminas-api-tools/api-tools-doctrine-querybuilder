<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\Service;

use Doctrine\ORM\QueryBuilder;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\FilterInterface;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\TypeCaster;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\TypeCastInterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception;
use RuntimeException;

use function get_class;
use function gettype;
use function is_object;
use function property_exists;
use function sprintf;
use function strtolower;

class ORMFilterManager extends AbstractPluginManager
{
    /** @var string */
    protected $instanceOf = FilterInterface::class;

    /**
     * @param object $metadata
     * @param iterable $filters
     */
    public function filter(QueryBuilder $queryBuilder, $metadata, $filters)
    {
        foreach ($filters as $option) {
            if (empty($option['type'])) {
                throw new RuntimeException('Array element "type" is required for all filters');
            }

            $typeCaster = $this->resolveTypeCaster();

            $filter = $this->get(strtolower($option['type']), [
                0                => $this,
                'filter_manager' => $this,
                'type_caster'    => $typeCaster,
            ]);
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

    /**
     * @return TypeCastInterface
     */
    protected function resolveTypeCaster()
    {
        if (property_exists($this, 'creationContext')) {
            $serviceLocator = $this->creationContext;
        } else {
            $serviceLocator = $this->getServiceLocator();
        }

        return $serviceLocator->get(TypeCaster::class);
    }
}
