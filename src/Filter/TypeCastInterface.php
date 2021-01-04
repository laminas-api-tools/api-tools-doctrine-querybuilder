<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter;

interface TypeCastInterface
{
    /**
     * @param object $metadata
     * @param string|int|float $value
     * @return mixed
     */
    public function typeCastField($metadata, string $field, $value, ?string $format = null, bool $doNotTypecastDatetime = false);
}
