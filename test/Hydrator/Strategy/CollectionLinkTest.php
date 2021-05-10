<?php

namespace LaminasTest\ApiTools\Doctrine\QueryBuilder\Hydrator\Strategy;

use laminas\apitools\doctrine\querybuilder\hydrator\strategy\collectionlink;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use stdClass;

class CollectionLinkTest extends TestCase
{
    use ProphecyTrait;

    /** @var stdClass|MockObject */
    private $mockValue;

    /** @var collectionlink */
    private $hydrator;

    public function setUp(): void
    {
        $this->mockValue = $this->getMockBuilder(stdClass::class)
            ->setMethods(['getTypeClass', 'getMapping', 'getOwner'])
            ->getMock();

        $this->mockValue->expects($this->any())
            ->method('getTypeClass')
            ->will($this->returnCallback(function () {
                $mockTypeClass       = new stdClass();
                $mockTypeClass->name = 'MockValue';

                return $mockTypeClass;
            }));

        $this->mockValue->expects($this->any())
                ->method('getOwner')
                ->will($this->returnCallback(function () {
                    $mockOwner = $this->getMockBuilder(stdClass::class)
                        ->setMethods(['getId'])
                        ->getMock();

                    $mockOwner->expects($this->any())
                        ->method('getId')
                        ->will($this->returnValue(123));

                    return $mockOwner;
                }));

        $config = [
            'api-tools-hal' => [
                'metadata_map' => [
                    $this->mockValue->getTypeClass()->name => [
                        'route_name'                              => 'my-route',
                        'api-tools-doctrine-querybuilder-options' => [
                            'filter_key' => 'my-filter-key',
                        ],
                    ],
                ],
            ],
        ];

        $mock = $this->prophesize(ServiceManager::class);
        $mock->get('config')->willReturn($config);

        $this->hydrator = new collectionlink();
        $this->hydrator->setServiceManager($mock->reveal());
    }

    public function mappingDataProvider(): array
    {
        return [
            // OneToMany relation
            [
                [
                    'fieldName'        => 'posts',
                    'mappedBy'         => 'blog',
                    'targetEntity'     => 'Application\\Model\\Post',
                    'cascade'          => [],
                    'orphanRemoval'    => false,
                    'fetch'            => 2,
                    'type'             => 4,
                    'inversedBy'       => null,
                    'isOwningSide'     => false,
                    'sourceEntity'     => 'Application\\Model\\Blog',
                    'isCascadeRemove'  => false,
                    'isCascadePersist' => false,
                    'isCascadeRefresh' => false,
                    'isCascadeMerge'   => false,
                    'isCascadeDetach'  => false,
                ],
                [
                    'query' => [
                        'my-filter-key' => [
                            [
                                'field' => 'blog',
                                'type'  => 'eq',
                                'value' => 123,
                            ],
                        ],
                    ],
                ],
            ],
            // ManyToMany relation
            [
                [
                    'fieldName' => 'posts',
                    'joinTable'
                    => [
                        'name'               => 'tag_post',
                        'joinColumns'        => [
                            [
                                'name'                 => 'tag_id',
                                'referencedColumnName' => 'id',
                                'onDelete'             => 'CASCADE',
                            ],
                        ],
                        'inverseJoinColumns' => [
                            [
                                'name'                 => 'post_id',
                                'referencedColumnName' => 'id',
                                'onDelete'             => 'CASCADE',
                            ],
                        ],
                    ],
                    'targetEntity'               => 'Application\\Model\\Post',
                    'mappedBy'                   => null,
                    'inversedBy'                 => 'tags',
                    'cascade'                    => [],
                    'orphanRemoval'              => false,
                    'fetch'                      => 2,
                    'type'                       => 8,
                    'isOwningSide'               => true,
                    'sourceEntity'               => 'Application\\Model\\Tag',
                    'isCascadeRemove'            => false,
                    'isCascadePersist'           => false,
                    'isCascadeRefresh'           => false,
                    'isCascadeMerge'             => false,
                    'isCascadeDetach'            => false,
                    'joinTableColumns'           => [
                        'tag_id',
                        'post_id',
                    ],
                    'isOnDeleteCascade'          => true,
                    'relationToSourceKeyColumns' => [
                        'tag_id' => 'id',
                    ],
                    'relationToTargetKeyColumns' => [
                        'post_id' => 'id',
                    ],
                ],
                [
                    'query' => [
                        'my-filter-key' => [
                            [
                                'field' => 'tags',
                                'type'  => 'ismemberof',
                                'value' => 123,
                            ],
                        ],
                    ],
                ],
            ],
            // ManyToMany inversed relation
            [
                [
                    'fieldName'        => 'tags',
                    'joinTable'        => [],
                    'targetEntity'     => 'Application\\Model\\Tag',
                    'mappedBy'         => 'posts',
                    'inversedBy'       => null,
                    'cascade'          => [],
                    'orphanRemoval'    => false,
                    'fetch'            => 2,
                    'type'             => 8,
                    'isOwningSide'     => false,
                    'sourceEntity'     => 'Application\\Model\\Post',
                    'isCascadeRemove'  => false,
                    'isCascadePersist' => false,
                    'isCascadeRefresh' => false,
                    'isCascadeMerge'   => false,
                    'isCascadeDetach'  => false,
                ],
                [
                    'query' => [
                        'my-filter-key' => [
                            [
                                'field' => 'posts',
                                'type'  => 'ismemberof',
                                'value' => 123,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider mappingDataProvider
     * @param array $mapping
     * @param array $expected
     */
    public function testStuff(array $mapping, array $expected)
    {
        $this->mockValue->expects($this->any())
                ->method('getMapping')
                ->will($this->returnValue($mapping));

        $actual = $this->hydrator->extract($this->mockValue);
        $this->assertEquals('my-route', $actual->getRoute());
        $this->assertEquals(['id' => null], $actual->getRouteParams());
        $this->assertEquals($expected, $actual->getRouteOptions());
    }
}
