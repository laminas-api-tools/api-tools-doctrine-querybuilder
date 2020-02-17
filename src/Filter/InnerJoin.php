<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\ORM\Filter;

use Exception;

class InnerJoin extends AbstractFilter
{
    public function filter($queryBuilder, $metadata, $option)
    {
        if (! isset($option['field']) || ! $option['field']) {
            throw new Exception('Field must be specified for inner join');
        }

        if (! isset($option['alias']) || ! $option['alias']) {
            throw new Exception('Alias must be specified for inner join');
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

        $queryBuilder->innerJoin(
            $option['parentAlias'] . '.' . $option['field'],
            $option['alias'],
            $option['conditionType'],
            $option['condition'],
            $option['indexBy']
        );
    }
}
