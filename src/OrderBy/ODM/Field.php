<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\ODM;

use Exception;

use function in_array;
use function strtolower;

class Field extends AbstractOrderBy
{
    /**
     * {@inheritDoc}
     */
    public function orderBy($queryBuilder, $metadata, $option)
    {
        if (! isset($option['direction']) || ! in_array(strtolower($option['direction']), ['asc', 'desc'])) {
            throw new Exception('Invalid direction in orderby directive');
        }

        $queryBuilder->sort($option['field'], $option['direction']);
    }
}
