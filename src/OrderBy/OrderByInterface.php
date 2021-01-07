<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

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
