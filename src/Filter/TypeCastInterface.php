<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter;

interface TypeCastInterface
{
    /**
     * @param object $metadata
     * @param string|int|float $value
     * @return mixed
     */
    public function typeCastField(
        $metadata,
        string $field,
        $value,
        ?string $format = null,
        bool $doNotTypecastDatetime = false
    );
}
