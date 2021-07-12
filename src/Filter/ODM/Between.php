<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM;

class Between extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    public function filter($queryBuilder, $metadata, $option)
    {
        $queryType = 'addAnd';

        if (isset($option['where'])) {
            if ($option['where'] === 'and') {
                $queryType = 'addAnd';
            } elseif ($option['where'] === 'or') {
                $queryType = 'addOr';
            }
        }

        $format = $option['format'] ?? null;

        $from = $this->typeCastField($metadata, $option['field'], $option['from'], $format);
        $to   = $this->typeCastField($metadata, $option['field'], $option['to'], $format);

        $queryBuilder->$queryType($queryBuilder->expr()->field($option['field'])->range($from, $to));
    }
}
