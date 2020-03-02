<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\Doctrine\ORM\QueryBuilder\OrderBy;

use DateTime;
use Db\Entity;
use Doctrine\ORM\Tools\SchemaTool;
use Laminas\ApiTools\Doctrine\ORM\QueryBuilder\OrderByManager;
use LaminasTest\ApiTools\Doctrine\ORM\QueryBuilder\TestCase;

class OrderByTest extends TestCase
{
    private function fetchResult(array $orderBy, $entity = 'Db\Entity\Artist')
    {
        $serviceManager = $this->getApplication()->getServiceManager();
        $orderByManager = $serviceManager->get(OrderByManager::class);
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');

        $queryBuilder = $objectManager->createQueryBuilder();
        $queryBuilder->select('row')
            ->from($entity, 'row');

        $metadata = $objectManager->getMetadataFactory()->getAllMetadata();

        $orderByManager->orderBy($queryBuilder, $metadata[0], $orderBy);

        $result = $queryBuilder->getQuery()->getResult();
        return $result;
    }

    protected function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/application.config.php'
        );
        parent::setUp();

        $serviceManager = $this->getApplication()->getServiceManager();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        print_r($serviceManager->get('config')['service_manager']);

        $tool = new SchemaTool($objectManager);
        $res = $tool->createSchema($objectManager->getMetadataFactory()->getAllMetadata());

        $artist1 = new Entity\Artist;
        $artist1->setName('ABBA');
        $artist1->setCreatedAt(new DateTime('2011-12-18 13:17:17'));
        $objectManager->persist($artist1);

        $artist2 = new Entity\Artist;
        $artist2->setName('Band, The');
        $artist2->setCreatedAt(new DateTime('2014-12-18 13:17:17'));
        $objectManager->persist($artist2);

        $artist3 = new Entity\Artist;
        $artist3->setName('CubanStack');
        $artist3->setCreatedAt(new DateTime('2012-12-18 13:17:17'));
        $objectManager->persist($artist3);

        $artist4 = new Entity\Artist;
        $artist4->setName('Drunk in July');
        $artist4->setCreatedAt(new DateTime('2013-12-18 13:17:17'));
        $objectManager->persist($artist4);

        $artist5 = new Entity\Artist;
        $artist5->setName('Ekoostic Hookah');
        $objectManager->persist($artist5);

        $objectManager->flush();
    }

    public function testField()
    {
        $orderBy = [
            [
                'type' => 'field',
                'field' => 'name',
                'direction' => 'desc',
            ],
        ];

        $result = $this->fetchResult($orderBy);
        $artist = reset($result);

        $this->assertEquals('Ekoostic Hookah', $artist->getName());


        $orderBy = [
            [
                'type' => 'field',
                'field' => 'name',
                'direction' => 'asc',
            ],
        ];

        $result = $this->fetchResult($orderBy);
        $artist = reset($result);

        $this->assertEquals('ABBA', $artist->getName());
    }
}
