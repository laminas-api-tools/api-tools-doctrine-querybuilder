<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider;

use Doctrine\ODM\MongoDB\Query\Builder;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\Service\ODMFilterManager;
use Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\Service\ODMOrderByManager;
use Laminas\ApiTools\Doctrine\Server\Paginator\Adapter\DoctrineOdmAdapter;
use Laminas\ApiTools\Doctrine\Server\Query\Provider\AbstractQueryProvider;
use Laminas\ApiTools\Doctrine\Server\Query\Provider\QueryProviderInterface;
use Laminas\ApiTools\Rest\ResourceEvent;
use Laminas\ServiceManager\ServiceLocatorInterface;

class DefaultOdm extends AbstractQueryProvider implements QueryProviderInterface
{
    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    /**
     * Set service locator
     *
     * @return self
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * {@inheritDoc}
     */
    public function createQuery(ResourceEvent $event, $entityClass, $parameters)
    {
        $request = $event->getRequest()->getQuery()->toArray();

        $queryBuilder = $this->getObjectManager()->createQueryBuilder();
        $queryBuilder->find($entityClass);

        if (isset($request[$this->getFilterKey()])) {
            $metadata = $this->getObjectManager()->getMetadataFactory()->getMetadataFor($entityClass);
            $this->getFilterManager()->filter(
                $queryBuilder,
                $metadata,
                $request[$this->getFilterKey()]
            );
        }

        if (isset($request[$this->getOrderByKey()])) {
            $metadata = $this->getObjectManager()->getMetadataFactory()->getMetadataFor($entityClass);
            $this->getOrderByManager()->orderBy(
                $queryBuilder,
                $metadata,
                $request[$this->getOrderByKey()]
            );
        }

        return $queryBuilder;
    }

    /**
     * @param Builder $queryBuilder
     * @return DoctrineOdmAdapter
     */
    public function getPaginatedQuery($queryBuilder)
    {
        return new DoctrineOdmAdapter($queryBuilder);
    }

    /**
     * @param string $entityClass
     * @return int
     */
    public function getCollectionTotal($entityClass)
    {
        $queryBuilder = $this->getObjectManager()->createQueryBuilder();
        $queryBuilder->find($entityClass);
        return $queryBuilder->getQuery()->execute()->count();
    }

    /**
     * @return string
     */
    protected function getFilterKey()
    {
        $config = $this->getConfig();
        if (isset($config['filter_key'])) {
            return $config['filter_key'];
        }

        return 'filter';
    }

    /**
     * @return string
     */
    protected function getOrderByKey()
    {
        $config = $this->getConfig();
        if (isset($config['order_by_key'])) {
            return $config['order_by_key'];
        }

        return 'order-by';
    }

    /**
     * @return array
     */
    protected function getConfig()
    {
        $config = $this->getServiceLocator()->get('config');
        if (isset($config['api-tools-doctrine-querybuilder-options'])) {
            return $config['api-tools-doctrine-querybuilder-options'];
        }

        return [];
    }

    /**
     * @return ODMFilterManager
     */
    protected function getFilterManager()
    {
        return $this->getServiceLocator()->get(ODMFilterManager::class);
    }

    /**
     * @return ODMOrderByManager
     */
    protected function getOrderByManager()
    {
        return $this->getServiceLocator()->get(ODMOrderByManager::class);
    }
}
