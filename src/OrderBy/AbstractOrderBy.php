<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\ODM\QueryBuilder\OrderBy;

use Laminas\ApiTools\Doctrine\ODM\QueryBuilder\OrderBy\OrderByInterface;
use Laminas\ApiTools\Doctrine\ODM\QueryBuilder\OrderByManager;

abstract class AbstractOrderBy implements OrderByInterface
{
    abstract public function orderBy($queryBuilder, $metadata, $option);

    protected $orderByManager;

    public function __construct($params)
    {
        $this->setOrderByManager($params[0]);
    }

    public function setOrderByManager(OrderByManager $orderByManager)
    {
        $this->orderByManager = $orderByManager;

        return $this;
    }

    public function getOrderByManager()
    {
        return $this->orderByManager;
    }
}
