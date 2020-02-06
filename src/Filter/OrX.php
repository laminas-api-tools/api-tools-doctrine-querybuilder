<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter;

use Doctrine\Common\Collections\ArrayCollection;

class OrX extends AbstractFilter
{
    public function filter($queryBuilder, $metadata, $option)
    {
        if (isset($option['where'])) {
            if ($option['where'] === 'and') {
                $queryType = 'andWhere';
            } elseif ($option['where'] === 'or') {
                $queryType = 'orWhere';
            }
        }

        if (! isset($queryType)) {
            $queryType = 'andWhere';
        }

        $orX = $queryBuilder->expr()->orX();
        $em  = $queryBuilder->getEntityManager();
        $qb  = $em->createQueryBuilder();

        foreach ($option['conditions'] as $condition) {
            $filter = $this->getFilterManager()
                ->get(
                    strtolower($condition['type']),
                    [$this->getFilterManager()]
                );
            $filter->filter($qb, $metadata, $condition);
        }

        $dqlParts = $qb->getDqlParts();
        $orX->addMultiple($dqlParts['where']->getParts());
        $queryBuilder->setParameters(
            new ArrayCollection(array_merge_recursive(
                $queryBuilder->getParameters()->toArray(),
                $qb->getParameters()->toArray()
            ))
        );

        $queryBuilder->$queryType($orX);
    }
}
