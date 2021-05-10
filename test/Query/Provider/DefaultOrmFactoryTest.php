<?php

namespace LaminasTest\ApiTools\Doctrine\QueryBuilder\Query\Provider;

use Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOrm;
use Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOrmFactory;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DefaultOrmFactoryTest extends TestCase
{
    use ProphecyTrait;

    public function testInvokableFactoryReturnsDefaultOrmQueryProvider(): void
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class)->reveal();

        $factory  = new DefaultOrmFactory();
        $provider = $factory($serviceLocator);

        $this->assertInstanceOf(DefaultOrm::class, $provider);
    }

    public function testInvokableFactoryReturnsDefaultOrmQueryProviderWhenCreatedViaAbstractPluginManager(): void
    {
        $serviceLocator        = $this->prophesize(ServiceLocatorInterface::class)->reveal();
        $abstractPluginManager = $this->prophesize(AbstractPluginManager::class);
        $abstractPluginManager->getServiceLocator()->willReturn($serviceLocator);

        $factory  = new DefaultOrmFactory();
        $provider = $factory($abstractPluginManager->reveal());

        $this->assertInstanceOf(DefaultOrm::class, $provider);
    }
}
