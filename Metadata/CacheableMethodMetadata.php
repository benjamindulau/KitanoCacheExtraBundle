<?php

namespace Ano\Bundle\KitanoCacheExtraBundle\Metadata;

use Kitano\CacheBundle\Metadata\CacheableMethodMetadata as BaseCacheableMethodMetadata;

class CacheableMethodMetadata extends BaseCacheableMethodMetadata
{
    public $type;

    public function serialize()
    {
        return serialize(array(
            parent::serialize(),
            $this->type,
        ));
    }

    public function unserialize($str)
    {
        list($parentStr,
            $this->type
            ) = unserialize($str);

        parent::unserialize($parentStr);
    }
}
