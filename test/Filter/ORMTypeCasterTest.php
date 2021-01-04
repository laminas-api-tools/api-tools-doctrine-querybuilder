<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\Doctrine\QueryBuilder\Filter;

use DateTime;
use DateTimeImmutable;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\TypeCaster;
use PHPUnit\Framework\TestCase;
use stdClass;

class ORMTypeCasterTest extends TestCase
{
    private $typeCaster;

    protected function setUp(): void
    {
        $this->typeCaster = new TypeCaster();
    }

    public function testTypeCastingToString()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'string',
            ],
        ];

        $field                 = 'field';
        $value                 = 1;
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);

        $this->assertSame('1', $result);
    }

    public function testTypeCastingToInteger()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'integer',
            ],
        ];

        $field                 = 'field';
        $value                 = '2144211244';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame(2144211244, $result);
    }

    public function testTypeCastingToSmallint()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'smallint',
            ],
        ];

        $field                 = 'field';
        $value                 = '2';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame(2, $result);
    }

    public function testTypeCastingToBoolean()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'boolean',
            ],
        ];

        $field                 = 'field';
        $value                 = 'abc';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame(true, $result);

        $value  = 0;
        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame(false, $result);
    }

    public function testTypeCastingToDecimal()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'decimal',
            ],
        ];

        $field                 = 'field';
        $value                 = '1.141';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame(1.141, $result);
    }

    public function testTypeCastingToFloat()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'float',
            ],
        ];

        $field                 = 'field';
        $value                 = '1.242';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame(1.242, $result);
    }

    public function testTypeCastingToDate()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'date',
            ],
        ];

        $field                 = 'field';
        $value                 = '2019-09-01';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertInstanceOf(DateTime::class, $result);
        $this->assertEquals($result->format('Y-m-d'), '2019-09-01');
        $this->assertEquals($result->format('H:i:s'), '00:00:00');
    }

    public function testNoTypeCastingToDateWhenFlaggedSo()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'date',
            ],
        ];

        $field                 = 'field';
        $value                 = '2019-09-01';
        $format                = null;
        $doNotTypecastDateTime = true;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame($result, $value);
    }

    public function testTypeCastingToDateImmutable()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'date_immutable',
            ],
        ];

        $field                 = 'field';
        $value                 = '2019-09-01';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertInstanceOf(DateTimeImmutable::class, $result);
        $this->assertEquals($result->format('Y-m-d'), '2019-09-01');
        $this->assertEquals($result->format('H:i:s'), '00:00:00');
    }

    public function testNoTypeCastingToDateImmutableWhenFlaggedSo()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'date_immutable',
            ],
        ];

        $field                 = 'field';
        $value                 = '2019-09-01';
        $format                = null;
        $doNotTypecastDateTime = true;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame($result, $value);
    }

    public function testTypeCastingToTime()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'time',
            ],
        ];

        $field                 = 'field';
        $value                 = '12:01:55';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertInstanceOf(DateTime::class, $result);
        $this->assertEquals($result->format('H:i:s'), '12:01:55');
    }

    public function testNoTypeCastingToTimeWhenFlaggedSo()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'time',
            ],
        ];

        $field                 = 'field';
        $value                 = '12:01:55';
        $format                = null;
        $doNotTypecastDateTime = true;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame($result, $value);
    }

    public function testTypeCastingToTimeImmutable()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'time_immutable',
            ],
        ];

        $field                 = 'field';
        $value                 = '12:01:55';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertInstanceOf(DateTimeImmutable::class, $result);
        $this->assertEquals($result->format('H:i:s'), '12:01:55');
    }

    public function testNoTypeCastingToTimeImmutableWhenFlaggedSo()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'time_immutable',
            ],
        ];

        $field                 = 'field';
        $value                 = '12:01:55';
        $format                = null;
        $doNotTypecastDateTime = true;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame($result, $value);
    }

    public function testTypeCastingToDateTime()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'datetime',
            ],
        ];

        $field                 = 'field';
        $value                 = '2019-09-01 12:03:44';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertInstanceOf(DateTime::class, $result);
        $this->assertEquals($result->format('Y-m-d'), '2019-09-01');
        $this->assertEquals($result->format('H:i:s'), '12:03:44');
    }

    public function testNoTypeCastingToDateTimeWhenFlaggedSo()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'datetime',
            ],
        ];

        $field                 = 'field';
        $value                 = '2019-09-01 12:03:44';
        $format                = null;
        $doNotTypecastDateTime = true;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame($result, $value);
    }

    public function testTypeCastingToDateTimeImmutable()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'datetime_immutable',
            ],
        ];

        $field                 = 'field';
        $value                 = '2019-09-01 12:03:44';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertInstanceOf(DateTimeImmutable::class, $result);
        $this->assertEquals($result->format('Y-m-d'), '2019-09-01');
        $this->assertEquals($result->format('H:i:s'), '12:03:44');
    }

    public function testNoTypeCastingToDateTimeImmutableWhenFlaggedSo()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'datetime_immutable',
            ],
        ];

        $field                 = 'field';
        $value                 = '2019-09-01 12:03:44';
        $format                = null;
        $doNotTypecastDateTime = true;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame($result, $value);
    }

    public function testTypeCastingForUnknownFieldType()
    {
        $metadata                = new stdClass();
        $metadata->fieldMappings = [
            'field' => [
                'type' => 'some random type',
            ],
        ];

        $field                 = 'field';
        $value                 = '2019-09-01 12:03:44';
        $format                = null;
        $doNotTypecastDateTime = false;

        $result = $this->typeCaster->typeCastField($metadata, $field, $value, $format, $doNotTypecastDateTime);
        $this->assertSame($result, $value);
    }
}
