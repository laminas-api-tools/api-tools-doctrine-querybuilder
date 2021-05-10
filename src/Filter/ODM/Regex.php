<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM;

use MongoRegex;

class Regex extends AbstractFilter
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

        $queryBuilder->$queryType(
            $queryBuilder
                ->expr()
                ->field($option['field'])
                ->equals(new MongoRegex($option['value']))
        );
    }
}
