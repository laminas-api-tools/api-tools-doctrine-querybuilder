<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter;

use Doctrine\ODM\MongoDB\Query\Builder;
use Doctrine\ORM\QueryBuilder;

interface FilterInterface
{
    /**
     * @param QueryBuilder|Builder $queryBuilder
     * @param object $metadata
     * @param array $option
     * @return void
     */
    public function filter($queryBuilder, $metadata, $option);
}
