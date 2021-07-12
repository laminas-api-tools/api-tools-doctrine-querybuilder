<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM;

class In extends AbstractFilter
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

        $queryValues = [];
        foreach ($option['values'] as $value) {
            $queryValues[]             = $this->typeCastField(
                $metadata,
                $option['field'],
                $value,
                $format,
                $doNotTypecastDatetime = true
            );
        }

        $queryBuilder->$queryType($queryBuilder->expr()->field($option['field'])->in($queryValues));
    }
}
