<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM;

use Doctrine\ORM\QueryBuilder;
use InvalidArgumentException;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\FilterInterface;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\Service\ORMFilterManager;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\TypeCastInterface;

abstract class AbstractFilter implements FilterInterface
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param object $metadata
     * @param array $option
     * @return void
     */
    abstract public function filter($queryBuilder, $metadata, $option);

    /** @var ORMFilterManager */
    protected $filterManager;

    /** @var TypeCastInterface */
    protected $typeCaster;

    public function __construct(array $params = [])
    {
        $this->setFilterManager($this->extractFilterManagerFromConstructorParams($params));
        $this->setTypeCaster($params['type_caster'] ?? new TypeCaster());
    }

    /**
     * @return $this
     */
    public function setFilterManager(ORMFilterManager $filterManager)
    {
        $this->filterManager = $filterManager;
        return $this;
    }

    /**
     * @return ORMFilterManager
     */
    public function getFilterManager()
    {
        return $this->filterManager;
    }

    /**
     * @return $this
     */
    public function setTypeCaster(TypeCastInterface $typeCaster)
    {
        $this->typeCaster = $typeCaster;
        return $this;
    }

    /**
     * @return TypeCastInterface
     */
    public function getTypeCaster()
    {
        return $this->typeCaster;
    }

    /**
     * @param object $metadata
     * @param string $field
     * @param string|int|float $value
     * @param string|null $format
     * @param bool $doNotTypecastDatetime
     * @return mixed
     */
    protected function typeCastField($metadata, $field, $value, $format, $doNotTypecastDatetime = false)
    {
        return $this->getTypeCaster()->typeCastField($metadata, $field, $value, $format, $doNotTypecastDatetime);
    }

    /**
     * @param array $params
     * @return ORMFilterManager
     */
    private function extractFilterManagerFromConstructorParams(array $params)
    {
        if (isset($params['filter_manager']) && $params['filter_manager'] instanceof ORMFilterManager) {
            return $params['filter_manager'];
        }

        if (isset($params[0]) && $params[0] instanceof ORMFilterManager) {
            return $params[0];
        }

        throw new InvalidArgumentException('Missing or invalid filter manager provided to ' . self::class);
    }
}
