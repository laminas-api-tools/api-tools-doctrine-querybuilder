<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\ORM;

use Exception;

class Field extends AbstractOrderBy
{
    public function orderBy($queryBuilder, $metadata, $option)
    {
        if (! isset($option['alias'])) {
            $option['alias'] = 'row';
        }

        if (! isset($option['direction']) || ! in_array(strtolower($option['direction']), ['asc', 'desc'])) {
            throw new Exception('Invalid direction in orderby directive');
        }

        $queryBuilder->addOrderBy($option['alias'] . '.' . $option['field'], $option['direction']);
    }
}
