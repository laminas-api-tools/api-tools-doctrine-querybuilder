<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\ODM;

use ArrayAccess;
use Doctrine\ODM\MongoDB\Query\Builder;
use Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\OrderByInterface;
use Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\Service\ODMOrderByManager;

abstract class AbstractOrderBy implements OrderByInterface
{
    /**
     * @param Builder $queryBuilder
     * @param object $metadata
     * @param array|ArrayAccess $option
     * @return void
     */
    abstract public function orderBy($queryBuilder, $metadata, $option);

    /** @var ODMOrderByManager */
    protected $orderByManager;

    /**
     * @param array|ArrayAccess $params
     */
    public function __construct($params)
    {
        $this->setOrderByManager($params[0]);
    }

    /**
     * @return self
     */
    public function setOrderByManager(ODMOrderByManager $orderByManager)
    {
        $this->orderByManager = $orderByManager;

        return $this;
    }

    /**
     * @return ODMOrderByManager
     */
    public function getOrderByManager()
    {
        return $this->orderByManager;
    }
}
