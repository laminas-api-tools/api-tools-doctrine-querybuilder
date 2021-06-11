<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\Doctrine\QueryBuilder\Query\Provider;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager as ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Doctrine\ORM\QueryBuilder;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\Service\ORMFilterManager;
use Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\Service\ORMOrderByManager;
use Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOrm;
use Laminas\ApiTools\Doctrine\Server\Paginator\Adapter\DoctrineOrmAdapter;
use Laminas\ApiTools\Rest\ResourceEvent;
use Laminas\Http\Request;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\Stdlib\Parameters;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ProphecyInterface;

class DefaultOrmTest extends TestCase
{
    use ProphecyTrait;

    /** @var DefaultOrm|ProphecyInterface */
    protected $provider;

    /** @var QueryBuilder|ProphecyInterface */
    protected $queryBuilder;

    /** @var ObjectManager|ProphecyInterface */
    protected $objectManager;

    /** @var ServiceLocatorInterface|ProphecyInterface */
    protected $serviceLocator;

    public function setUp(): void
    {
        $this->queryBuilder = $this->prophesize(QueryBuilder::class);
        $this->queryBuilder->select(Argument::any())->willReturn($this->queryBuilder->reveal());
        $this->queryBuilder->from(Argument::any(), Argument::any())->willReturn($this->queryBuilder->reveal());

        $this->objectManager = $this->prophesize(ObjectManager::class);
        $this->objectManager->createQueryBuilder()->willReturn($this->queryBuilder->reveal());

        $this->serviceLocator = $this->prophesize(ServiceLocatorInterface::class);

        $this->provider = new DefaultOrm();
        $this->provider->setServiceLocator($this->serviceLocator->reveal());
        $this->provider->setObjectManager($this->objectManager->reveal());
    }

    public function testCreateQueryWithoutParams(): void
    {
        $resourceEvent = $this->getResourceEvent();

        $result = $this->provider->createQuery($resourceEvent->reveal(), 'foo.entity.class', []);

        $this->assertInstanceOf(QueryBuilder::class, $result);
    }

    public function testCreateQueryWithFilterParameter(): void
    {
        $entityClass = 'foo.entity.class';

        $metadata = $this->prophesize(ClassMetadata::class)->reveal();
        $this->objectManager->getClassMetadata($entityClass)->willReturn($metadata);

        $filterManager = $this->prophesize(ORMFilterManager::class);
        $filterManager->filter($this->queryBuilder->reveal(), $metadata, 'foo-filter')->shouldBeCalledTimes(1);

        $this->serviceLocator->get('config')->willReturn([]);
        $this->serviceLocator->has(ORMFilterManager::class)->willReturn(true);
        $this->serviceLocator->get(ORMFilterManager::class)->willReturn($filterManager->reveal());

        $resourceEvent = $this->getResourceEvent(['filter' => 'foo-filter']);

        $result = $this->provider->createQuery($resourceEvent->reveal(), $entityClass, []);

        $this->assertInstanceOf(QueryBuilder::class, $result);
        $this->assertSame($this->queryBuilder->reveal(), $result);
    }

    public function testCreateQueryWithRenamedFilterParameter(): void
    {
        $entityClass = 'foo.entity.class';

        $metadata = $this->prophesize(ClassMetadata::class)->reveal();
        $this->objectManager->getClassMetadata($entityClass)->willReturn($metadata);

        $filterManager = $this->prophesize(ORMFilterManager::class);
        $filterManager->filter($this->queryBuilder->reveal(), $metadata, 'foo-filter-renamed')->shouldBeCalledTimes(1);

        $this->serviceLocator->get('config')->willReturn([
            'api-tools-doctrine-querybuilder-options' => [
                'filter_key' => 'renamed-filter-param',
            ],
        ]);
        $this->serviceLocator->has(ORMFilterManager::class)->willReturn(true);
        $this->serviceLocator->get(ORMFilterManager::class)->willReturn($filterManager->reveal());

        $resourceEvent = $this->getResourceEvent(['renamed-filter-param' => 'foo-filter-renamed']);

        $result = $this->provider->createQuery($resourceEvent->reveal(), $entityClass, []);

        $this->assertInstanceOf(QueryBuilder::class, $result);
        $this->assertSame($this->queryBuilder->reveal(), $result);
    }

    public function testCreateQueryWithOrderByParameter(): void
    {
        $entityClass = 'foo.entity.class';

        $metadata = $this->prophesize(ClassMetadata::class)->reveal();
        $this->objectManager->getClassMetadata($entityClass)->willReturn($metadata);

        $orderByManager = $this->prophesize(ORMOrderByManager::class);
        $orderByManager->orderBy($this->queryBuilder->reveal(), $metadata, 'foo-order-by')->shouldBeCalledTimes(1);

        $this->serviceLocator->get('config')->willReturn([]);
        $this->serviceLocator->has(ORMOrderByManager::class)->willReturn(true);
        $this->serviceLocator->get(ORMOrderByManager::class)->willReturn($orderByManager->reveal());

        $resourceEvent = $this->getResourceEvent(['order-by' => 'foo-order-by']);

        $result = $this->provider->createQuery($resourceEvent->reveal(), $entityClass, []);

        $this->assertInstanceOf(QueryBuilder::class, $result);
        $this->assertSame($this->queryBuilder->reveal(), $result);
    }

    public function testCreateQueryWithRenamedOrderByParameter(): void
    {
        $entityClass = 'foo.entity.class';

        $metadata = $this->prophesize(ClassMetadata::class)->reveal();
        $this->objectManager->getClassMetadata($entityClass)->willReturn($metadata);

        $orderByManager = $this->prophesize(ORMOrderByManager::class);
        $orderByManager->orderBy($this->queryBuilder->reveal(), $metadata, 'FooOrderBy')->shouldBeCalledTimes(1);

        $this->serviceLocator->get('config')->willReturn([
            'api-tools-doctrine-querybuilder-options' => [
                'order_by_key' => 'renamed-order-by-param',
            ],
        ]);
        $this->serviceLocator->has(ORMOrderByManager::class)->willReturn(true);
        $this->serviceLocator->get(ORMOrderByManager::class)->willReturn($orderByManager->reveal());

        $resourceEvent = $this->getResourceEvent(['renamed-order-by-param' => 'FooOrderBy']);

        $result = $this->provider->createQuery($resourceEvent->reveal(), $entityClass, []);

        $this->assertInstanceOf(QueryBuilder::class, $result);
        $this->assertSame($this->queryBuilder->reveal(), $result);
    }

    public function testCreateQueryWithFilterAndOrderByParameters(): void
    {
        $entityClass = 'foo.entity.class';

        $metadata = $this->prophesize(ClassMetadata::class)->reveal();
        $this->objectManager->getClassMetadata($entityClass)->willReturn($metadata);

        $filterManager = $this->prophesize(ORMFilterManager::class);
        $filterManager->filter($this->queryBuilder->reveal(), $metadata, 'foo-filter')->shouldBeCalledTimes(1);

        $orderByManager = $this->prophesize(ORMOrderByManager::class);
        $orderByManager->orderBy($this->queryBuilder->reveal(), $metadata, 'foo-order-by')->shouldBeCalledTimes(1);

        $this->serviceLocator->get('config')->willReturn([]);
        $this->serviceLocator->has(ORMOrderByManager::class)->willReturn(true);
        $this->serviceLocator->get(ORMOrderByManager::class)->willReturn($orderByManager->reveal());
        $this->serviceLocator->has(ORMFilterManager::class)->willReturn(true);
        $this->serviceLocator->get(ORMFilterManager::class)->willReturn($filterManager->reveal());

        $resourceEvent = $this->getResourceEvent([
            'filter'   => 'foo-filter',
            'order-by' => 'foo-order-by',
        ]);

        $result = $this->provider->createQuery($resourceEvent->reveal(), $entityClass, []);

        $this->assertInstanceOf(QueryBuilder::class, $result);
        $this->assertSame($this->queryBuilder->reveal(), $result);
    }

    public function testGetPaginatedQuery(): void
    {
        $query = $this->prophesize(AbstractQuery::class);
        $this->queryBuilder->getQuery()->willReturn($query->reveal());

        $adapter = $this->provider->getPaginatedQuery($this->queryBuilder->reveal());

        $this->assertInstanceOf(DoctrineOrmAdapter::class, $adapter);
    }

    public function testGetCollectionTotal(): void
    {
        $entityClass = 'foo.entity.class';

        $metadata = $this->prophesize(ClassMetadata::class);
        $metadata->getIdentifier()->willReturn(['id']);

        $metadataFactory = $this->prophesize(ClassMetadataFactory::class);
        $metadataFactory->getMetadataFor($entityClass)->willReturn($metadata->reveal());

        $this->objectManager->getMetadataFactory()->willReturn($metadataFactory->reveal());

        $query = $this->prophesize(AbstractQuery::class);
        $query->getSingleScalarResult()->willReturn(783);
        $this->queryBuilder->getQuery()->willReturn($query->reveal());

        $count = $this->provider->getCollectionTotal($entityClass);

        $this->assertEquals(783, $count);
    }

    /**
     * @param array|null $params
     * @return ResourceEvent|ProphecyInterface
     */
    protected function getResourceEvent(?array $params = null)
    {
        $request = $this->prophesize(Request::class);
        $request->getQuery()->willReturn(new Parameters($params));

        $resourceEvent = $this->prophesize(ResourceEvent::class);
        $resourceEvent->getRequest()->willReturn($request->reveal());

        return $resourceEvent;
    }
}
