<?php

namespace Ano\Bundle\KitanoCacheExtraBundle\Annotation;

use Kitano\CacheBundle\Annotation\Cache as BaseCache;

/**
 * Represents a @Cacheable annotation.
 *
 * @Annotation
 * @Target("METHOD")
 * @author Benjamin Dulau <benjamin.dulau@gmail.com>
 */
abstract class Cache extends BaseCache
{
    /**
     * @var string
     */
    public $type;

    public function __construct(array $values)
    {
        parent::__construct($values);

        if (isset($values['type'])) {
            $this->type = $values['type'];
        }
    }
}
