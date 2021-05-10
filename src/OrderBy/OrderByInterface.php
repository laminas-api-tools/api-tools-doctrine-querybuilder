<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy;

use ArrayAccess;
use Doctrine\ODM\MongoDB\Query\Builder;
use Doctrine\ORM\QueryBuilder;

interface OrderByInterface
{
    /**
     * @param QueryBuilder|Builder $queryBuilder
     * @param object $metadata
     * @param array|ArrayAccess $option
     * @return void
     */
    public function orderBy($queryBuilder, $metadata, $option);
}
