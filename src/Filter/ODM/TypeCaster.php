<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM;

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
            case 'int':
                $value = (int) $value;
                break;
            case 'boolean':
                $value = (bool) $value;
                break;
            case 'float':
                $value = (float) $value;
                break;
            case 'string':
                $value = (string) $value;
                break;
            case 'bin_data_custom':
                break;
            case 'bin_data_func':
                break;
            case 'bin_data_md5':
                break;
            case 'bin_data':
                break;
            case 'bin_data_uuid':
                break;
            case 'collection':
                break;
            case 'custom_id':
                break;
            case 'date':
                if ($value && ! $doNotTypecastDatetime) {
                    if (! $format) {
                        $format = 'Y-m-d H:i:s';
                    }
                    $value = DateTime::createFromFormat($format, $value);
                }
                break;
            case 'date_immutable':
                if ($value && ! $doNotTypecastDatetime) {
                    if (! $format) {
                        $format = 'Y-m-d H:i:s';
                    }
                    $value = DateTimeImmutable::createFromFormat($format, $value);
                }
                break;
            case 'file':
                break;
            case 'hash':
                break;
            case 'id':
                break;
            case 'increment':
                break;
            case 'key':
                break;
            case 'object_id':
                break;
            case 'raw_type':
                break;
            case 'timestamp':
                break;
            default:
                break;
        }

        return $value;
    }
}
