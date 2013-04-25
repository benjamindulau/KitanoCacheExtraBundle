<?php

namespace Ano\Bundle\KitanoCacheExtraBundle\EventListener;

use Kitano\CacheBundle\Event\CacheHitEvent;
use Kitano\CacheBundle\Event\CacheUpdateEvent;
use JMS\SerializerBundle\Serializer\SerializerInterface;
use Kitano\CacheBundle\Cache\CacheManagerInterface;
use Ano\Bundle\KitanoCacheExtraBundle\SerializedCacheValue;

class CacheEventListener
{
    private $serializer;
    private $cacheManager;

    public function __construct(SerializerInterface $serializer, CacheManagerInterface $cacheManager)
    {
        $this->serializer = $serializer;
        $this->cacheManager = $cacheManager;
    }

    public function onAfterCacheHit(CacheHitEvent $event)
    {
        $value = $event->getValue();
        if ($value instanceof SerializedCacheValue) {
            $value = $this->serializer->deserialize($value->data, $value->type, 'json');
            $event->setValue($value);
        }
    }

    public function onAfterCacheUpdate(CacheUpdateEvent $event)
    {
        $cache = $event->getCache();
        $key = $event->getKey();
        $metadata = $event->getMetadata();

        if (null !== $metadata->type) {
            $serializedValue = $this->serializer->serialize($event->getValue(), 'json');
            $value = new SerializedCacheValue($metadata->type, $serializedValue);
            $this->cacheManager->getCache($cache)->set($key, $value);
        }
    }
}
