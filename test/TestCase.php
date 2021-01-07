<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

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
