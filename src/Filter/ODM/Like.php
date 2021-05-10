<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM;

use MongoRegex;

use function str_replace;

class Like extends AbstractFilter
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

        $regex = '/' . str_replace('%', '.*?', $option['value']) . '/i';

        $queryBuilder->$queryType(
            $queryBuilder
              ->expr()
              ->field($option['field'])
              ->equals(new MongoRegex($regex))
        );
    }
}
