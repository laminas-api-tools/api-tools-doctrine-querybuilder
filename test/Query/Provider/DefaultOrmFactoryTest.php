<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\Doctrine\QueryBuilder\Query\Provider;

use Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOrm;
use Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOrmFactory;
use Laminas\ServiceManager\ServiceLocatorInterface;
use PHPUnit_Framework_TestCase as TestCase;

class DefaultOrmFactoryTest extends TestCase
{
    public function testInvokableFactoryReturnsDefaultOdmQueryProvider()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class)->reveal();

        $factory = new DefaultOrmFactory();
        $provider = $factory($serviceLocator);

        $this->assertInstanceOf(DefaultOrm::class, $provider);
        $this->assertAttributeSame($serviceLocator, 'serviceLocator', $provider);
    }
}
