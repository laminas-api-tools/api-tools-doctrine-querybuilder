<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder;

use Laminas\Hydrator\HydratorPluginManagerInterface;

use function class_alias;
use function interface_exists;

/**
 * Alias Laminas\ApiTools\Hal\Extractor\EntityExtractor to the appropriate class based on
 * which version of laminas-hydrator we detect. HydratorPluginManagerInterface
 * is added in v3.
 */
if (interface_exists(HydratorPluginManagerInterface::class, true)) {
    class_alias(Hydrator\Strategy\CollectionLinkHydratorV3::class, hydrator\strategy\collectionlink::class, true);
} else {
    class_alias(Hydrator\Strategy\CollectionLinkHydratorV2::class, hydrator\strategy\collectionlink::class, true);
}
