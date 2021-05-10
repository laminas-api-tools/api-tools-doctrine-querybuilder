<?php

namespace LaminasTest\ApiTools\Doctrine\QueryBuilder\Query\Provider;

use Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOdm;
use Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOdmFactory;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DefaultOdmFactoryTest extends TestCase
{
    use ProphecyTrait;

    public function testInvokableFactoryReturnsDefaultOdmQueryProvider(): void
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class)->reveal();

        $factory  = new DefaultOdmFactory();
        $provider = $factory($serviceLocator);

        $this->assertInstanceOf(DefaultOdm::class, $provider);
    }

    public function testInvokableFactoryReturnsDefaultOdmQueryProviderWhenCreatedViaAbstractPluginManager(): void
    {
        $serviceLocator        = $this->prophesize(ServiceLocatorInterface::class)->reveal();
        $abstractPluginManager = $this->prophesize(AbstractPluginManager::class);
        $abstractPluginManager->getServiceLocator()->willReturn($serviceLocator);

        $factory  = new DefaultOdmFactory();
        $provider = $factory($abstractPluginManager->reveal());

        $this->assertInstanceOf(DefaultOdm::class, $provider);
    }
}
