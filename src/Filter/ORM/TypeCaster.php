<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM;

use DateTime;
use DateTimeImmutable;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\TypeCastInterface;

class TypeCaster implements TypeCastInterface
{
    /**
     * {@inheritDoc}
     */
    public function typeCastField(
        $metadata,
        string $field,
        $value,
        ?string $format = null,
        bool $doNotTypecastDatetime = false
    ) {
        if (! isset($metadata->fieldMappings[$field])) {
            return $value;
        }

        switch ($metadata->fieldMappings[$field]['type']) {
            case 'string':
                $value = (string) $value;
                break;
            case 'integer':
            case 'smallint':
                // case 'bigint':  // Don't try to manipulate bigints?
                $value = (int) $value;
                break;
            case 'boolean':
                $value = (bool) $value;
                break;
            case 'decimal':
            case 'float':
                $value = (float) $value;
                break;
            case 'date':
                // For dates set time to midnight
                if ($value && ! $doNotTypecastDatetime) {
                    if (! $format) {
                        $format = 'Y-m-d';
                    }
                    $value = DateTime::createFromFormat($format, $value);
                    $value = DateTime::createFromFormat('Y-m-d H:i:s', $value->format('Y-m-d') . ' 00:00:00');
                }
                break;
            case 'date_immutable':
                // For dates set time to midnight
                if ($value && ! $doNotTypecastDatetime) {
                    if (! $format) {
                        $format = 'Y-m-d';
                    }
                    $value = DateTimeImmutable::createFromFormat($format, $value);
                    $value = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $value->format('Y-m-d') . ' 00:00:00');
                }
                break;
            case 'time':
                if ($value && ! $doNotTypecastDatetime) {
                    if (! $format) {
                        $format = 'H:i:s';
                    }
                    $value = DateTime::createFromFormat($format, $value);
                }
                break;
            case 'time_immutable':
                if ($value && ! $doNotTypecastDatetime) {
                    if (! $format) {
                        $format = 'H:i:s';
                    }
                    $value = DateTimeImmutable::createFromFormat($format, $value);
                }
                break;
            case 'datetime':
                if ($value && ! $doNotTypecastDatetime) {
                    if (! $format) {
                        $format = 'Y-m-d H:i:s';
                    }
                    $value = DateTime::createFromFormat($format, $value);
                }
                break;
            case 'datetime_immutable':
                if ($value && ! $doNotTypecastDatetime) {
                    if (! $format) {
                        $format = 'Y-m-d H:i:s';
                    }
                    $value = DateTimeImmutable::createFromFormat($format, $value);
                }
                break;
            default:
                break;
        }

        return $value;
    }
}
