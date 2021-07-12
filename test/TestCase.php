<?php

namespace LaminasTest\ApiTools\Doctrine\QueryBuilder;

use ArrayAccess;
use Laminas\Mvc\Application;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use ReflectionClass;

use function array_unshift;

class TestCase extends AbstractHttpControllerTestCase
{
    /**
     * @param array|ArrayAccess $config
     */
    public function setApplicationConfig($config): void
    {
        $r          = (new ReflectionClass(Application::class))->getConstructor();
        $appVersion = $r->getNumberOfRequiredParameters() === 2 ? 2 : 3;
        if ($appVersion === 3) {
            array_unshift($config['modules'], 'Laminas\Router', 'Laminas\Hydrator');
        }

        parent::setApplicationConfig($config);
    }
}
