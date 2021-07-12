<?php

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
    // phpcs:ignore
    class_alias(Hydrator\Strategy\CollectionLinkHydratorV3::class, Hydrator\Strategy\Collectionlink::class, true);
} else {
    // phpcs:ignore
    class_alias(Hydrator\Strategy\CollectionLinkHydratorV2::class, Hydrator\Strategy\Collectionlink::class, true);
}
