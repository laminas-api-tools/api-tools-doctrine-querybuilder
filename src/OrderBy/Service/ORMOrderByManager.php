<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\Service;

use Doctrine\ORM\QueryBuilder;
use Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\OrderByInterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception;

class ORMOrderByManager extends AbstractPluginManager
{
    protected $invokableClasses = array();

    public function orderBy(QueryBuilder $queryBuilder, $metadata, $orderBy)
    {
        foreach ($orderBy as $option) {
            if (! isset($option['type']) or ! $option['type']) {
                // @codeCoverageIgnoreStart
                throw new Exception\RuntimeException('Array element "type" is required for all orderby directives');
            }
            // @codeCoverageIgnoreEnd

            $orderByHandler = $this->get(strtolower($option['type']), array($this));

            $orderByHandler->orderBy($queryBuilder, $metadata, $option);
        }
    }

    /**
     * @param mixed $orderBy
     *
     * @return void
     * @throws Exception\RuntimeException
     */
    public function validatePlugin($orderBy)
    {
        if ($orderBy instanceof OrderByInterface) {
            // we're okay
            return;
        }

        // @codeCoverageIgnoreStart
        throw new Exception\RuntimeException(sprintf(
            'Plugin of type %s is invalid; must implement %s\Plugin\PluginInterface',
            (is_object($orderBy) ? get_class($orderBy) : gettype($orderBy)),
            __NAMESPACE__
        ));
        // @codeCoverageIgnoreEnd
    }
}
