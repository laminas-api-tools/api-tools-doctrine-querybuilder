<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM;

class Between extends AbstractFilter
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

        if (! isset($option['alias'])) {
            $option['alias'] = 'row';
        }

        $format = isset($option['format']) ? $option['format'] : null;

        $from = $this->typeCastField($metadata, $option['field'], $option['from'], $format);
        $to = $this->typeCastField($metadata, $option['field'], $option['to'], $format);

        $fromParameter = uniqid('a1');
        $toParameter = uniqid('a2');

        $queryBuilder->$queryType(
            $queryBuilder
                ->expr()
                ->between(
                    sprintf('%s.%s', $option['alias'], $option['field']),
                    sprintf(':%s', $fromParameter),
                    sprintf(':%s', $toParameter)
                )
        );
        $queryBuilder->setParameter($fromParameter, $from);
        $queryBuilder->setParameter($toParameter, $to);
    }
}
