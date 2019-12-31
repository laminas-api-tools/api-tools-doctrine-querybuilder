<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Laminas\ApiTools\Doctrine\Server\Paginator\Adapter\DoctrineOdmAdapter;
use Laminas\ApiTools\Doctrine\Server\Query\Provider\QueryProviderInterface;
use Laminas\ApiTools\Rest\ResourceEvent;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class DefaultOdm implements QueryProviderInterface, ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator = null;

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
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
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * Set the object manager
     *
     * @param ObjectManager $objectManager
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Get the object manager
     *
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * {@inheritDoc}
     */
    public function createQuery(ResourceEvent $event, $entityClass, $parameters)
    {
        $request = $this->getServiceLocator()->get('Application')->getRequest()->getQuery()->toArray();

        $queryBuilder = $this->getObjectManager()->createQueryBuilder();
        $queryBuilder->find($entityClass);

        if (isset($request[$this->getFilterKey()])) {
            $metadata = $this->getObjectManager()->getMetadataFactory()->getAllMetadata();
            $filterManager = $this->getServiceLocator()->get('LaminasDoctrineQueryBuilderFilterManagerOrm');
            $filterManager->filter(
                $queryBuilder,
                $metadata[0],
                $request[$this->getFilterKey()]
            );
        }

        if (isset($request[$this->getOrderByKey()])) {
            $metadata = $this->getObjectManager()->getMetadataFactory()->getAllMetadata();
            $orderByManager = $this->getServiceLocator()->get('LaminasDoctrineQueryBuilderOrderByManagerOrm');
            $orderByManager->orderBy(
                $queryBuilder,
                $metadata[0],
                $request[$this->getOrderByKey()]
            );
        }

        return $queryBuilder;
    }

    /**
     * @param   $queryBuilder
     *
     * @return DoctrineOdmAdapter
     */
    public function getPaginatedQuery($queryBuilder)
    {
        $adapter = new DoctrineOdmAdapter($queryBuilder);

        return $adapter;
    }

    /**
     * @param   $entityClass
     *
     * @return int
     */
    public function getCollectionTotal($entityClass)
    {
        $queryBuilder = $this->getObjectManager()->createQueryBuilder();
        $queryBuilder->find($entityClass);
        $count = $queryBuilder->getQuery()->execute()->count();

        return $count;
    }

    /**
     * @return string
     */
    protected function getFilterKey()
    {
        $config = $this->getServiceLocator()->getServiceLocator()->get('Config');

        if (isset($config['api-tools-doctrine-querybuilder-options']['filter_key'])) {
            $filterKey = $config['api-tools-doctrine-querybuilder-options']['filter_key'];
        } else {
            $filterKey = 'filter';
        }

        return $filterKey;
    }

    /**
     * @return string
     */
    protected function getOrderByKey()
    {
        $config = $this->getServiceLocator()->getServiceLocator()->get('Config');

        if (isset($config['api-tools-doctrine-querybuilder-options']['order_by_key'])) {
            $orderByKey = $config['api-tools-doctrine-querybuilder-options']['order_by_key'];
        } else {
            $orderByKey = 'order-by';
        }

        return $orderByKey;
    }
}
