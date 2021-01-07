<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\ORM;

use ArrayAccess;
use Doctrine\ORM\QueryBuilder;
use Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\OrderByInterface;
use Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\Service\ORMOrderByManager;

abstract class AbstractOrderBy implements OrderByInterface
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param object $metadata
     * @param array|ArrayAccess $option
     * @return void
     */
    abstract public function orderBy($queryBuilder, $metadata, $option);

    /** @var ORMOrderByManager */
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
    public function setOrderByManager(ORMOrderByManager $orderByManager)
    {
        $this->orderByManager = $orderByManager;

        return $this;
    }

    /**
     * @return ORMOrderByManager
     */
    public function getOrderByManager()
    {
        return $this->orderByManager;
    }
}
