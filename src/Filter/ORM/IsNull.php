<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM;

class IsNull extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    public function filter($queryBuilder, $metadata, $option)
    {
        if (isset($option['where'])) {
            if ($option['where'] === 'and') {
                $queryType = 'andWhere';
            } elseif ($option['where'] === 'or') {
                $queryType = 'orWhere';
            }
        }

        if (! isset($queryType)) {
            $queryType = 'andWhere';
        }

        if (! isset($option['alias'])) {
            $option['alias'] = 'row';
        }

        $queryBuilder->$queryType(
            $queryBuilder
                ->expr()
                ->isNull($option['alias'] . '.' . $option['field'])
        );
    }
}
