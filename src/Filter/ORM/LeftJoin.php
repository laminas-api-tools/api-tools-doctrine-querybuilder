<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM;

use Exception;

class LeftJoin extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    public function filter($queryBuilder, $metadata, $option)
    {
        if (! isset($option['field']) || ! $option['field']) {
            throw new Exception('Field must be specified for left  join');
        }

        if (! isset($option['alias']) || ! $option['alias']) {
            throw new Exception('Alias must be specified for left join');
        }

        if (! isset($option['parentAlias']) || ! $option['parentAlias']) {
            $option['parentAlias'] = 'row';
        }

        if (! isset($option['conditionType']) && isset($option['condition'])) {
            throw new Exception('A conditionType must be specified for a condition');
        }

        if (! isset($option['condition']) && isset($option['conditionType'])) {
            throw new Exception('A condition must be specified for a conditionType');
        }

        if (! isset($option['conditionType'])) {
            $option['conditionType'] = null;
        }

        if (! isset($option['condition'])) {
            $option['condition'] = null;
        }

        if (! isset($option['indexBy'])) {
            $option['indexBy'] = null;
        }

        $queryBuilder->leftJoin(
            $option['parentAlias'] . '.' . $option['field'],
            $option['alias'],
            $option['conditionType'],
            $option['condition'],
            $option['indexBy']
        );
    }
}
