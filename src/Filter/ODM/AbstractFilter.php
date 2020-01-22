<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM;

use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\FilterInterface;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\TypeCastInterface;

abstract class AbstractFilter implements FilterInterface
{
    abstract public function filter($queryBuilder, $metadata, $option);

    /**
     * @var TypeCastInterface
     */
    protected $typeCaster;

    public function __construct(array $params = [])
    {
        $this->setTypeCaster($params['type_caster'] ?? new TypeCaster());
    }

    /**
     * @param TypeCastInterface $typeCaster
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
    protected function getTypeCaster()
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
    protected function typeCastField($metadata, string $field, $value, string $format = null, bool $doNotTypecastDatetime = false)
    {
        return $this->getTypeCaster()->typeCastField($metadata, $field, $value, $format, $doNotTypecastDatetime);
    }
}
