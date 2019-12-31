<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM;

class LessThan extends AbstractFilter
{
    public function filter($queryBuilder, $metadata, $option)
    {
        $queryType = 'addAnd';
        if (isset($option['where'])) {
            if ($option['where'] === 'and') {
                $queryType = 'addAnd';
            } elseif ($option['where'] === 'or') {
                $queryType = 'addOr';
            }
        }

        $format = isset($option['format']) ? $option['format'] : null;

        $value = $this->typeCastField($metadata, $option['field'], $option['value'], $format);

        $queryBuilder->$queryType($queryBuilder->expr()->field($option['field'])->lt($value));
    }
}
