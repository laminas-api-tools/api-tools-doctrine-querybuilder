<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider;

use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\Service\ORMFilterManager;
use Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\Service\ORMOrderByManager;
use Laminas\ApiTools\Doctrine\Server\Query\Provider\AbstractQueryProvider;
use Laminas\ApiTools\Doctrine\Server\Query\Provider\QueryProviderInterface;
use Laminas\ApiTools\Rest\ResourceEvent;
use Laminas\ServiceManager\ServiceLocatorInterface;

class DefaultOrm extends AbstractQueryProvider implements QueryProviderInterface
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
        $request      = $event->getRequest()->getQuery()->toArray();
        $queryBuilder = $this->getObjectManager()->createQueryBuilder();
        $queryBuilder->select('row')
            ->from($entityClass, 'row');

        if (isset($request[$this->getFilterKey()])) {
            $metadata = $this->getObjectManager()->getClassMetadata($entityClass);
            $this->getFilterManager()->filter(
                $queryBuilder,
                $metadata,
                $request[$this->getFilterKey()]
            );
        }

        if (isset($request[$this->getOrderByKey()])) {
            $metadata = $this->getObjectManager()->getClassMetadata($entityClass);
            $this->getOrderByManager()->orderBy(
                $queryBuilder,
                $metadata,
                $request[$this->getOrderByKey()]
            );
        }

        return $queryBuilder;
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
     * @return ORMFilterManager
     */
    protected function getFilterManager()
    {
        return $this->getServiceLocator()->get(ORMFilterManager::class);
    }

    /**
     * @return ORMOrderByManager
     */
    protected function getOrderByManager()
    {
        return $this->getServiceLocator()->get(ORMOrderByManager::class);
    }
}
