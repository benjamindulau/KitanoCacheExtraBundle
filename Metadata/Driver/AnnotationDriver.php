<?php

namespace Ano\Bundle\KitanoCacheExtraBundle\Metadata\Driver;

use Kitano\CacheBundle\Metadata\Driver\AnnotationDriver as BaseAnnotationDriver;
use Kitano\CacheBundle\Annotation\Cache;
use Kitano\CacheBundle\Annotation\CacheEvict;
use Kitano\CacheBundle\Metadata\CacheEvictMethodMetadata;
use Pel\Expression\Expression;

use Ano\Bundle\KitanoCacheExtraBundle\Annotation\Cacheable;
use Ano\Bundle\KitanoCacheExtraBundle\Annotation\CacheUpdate;
use Ano\Bundle\KitanoCacheExtraBundle\Metadata\CacheableMethodMetadata;
use Ano\Bundle\KitanoCacheExtraBundle\Metadata\CacheUpdateMethodMetadata;

class AnnotationDriver extends BaseAnnotationDriver
{
    protected function convertMethodAnnotations(\ReflectionMethod $method, array $annotations)
    {
        $parameters = array();
        foreach ($method->getParameters() as $index => $parameter) {
            $parameters[$parameter->getName()] = $index;
        }

        $hasCacheMetadata = false;
        $methodMetadata   = null;

        foreach ($annotations as $annotation) {
            if ($annotation instanceof Cache) {
                if ($annotation instanceof Cacheable) {
                    $methodMetadata = new CacheableMethodMetadata($method->class, $method->name);
                    $methodMetadata->type = $annotation->type;
                } elseif ($annotation instanceof CacheEvict) {
                    $methodMetadata = new CacheEvictMethodMetadata($method->class, $method->name);
                    $methodMetadata->allEntries = $annotation->allEntries;
                } elseif ($annotation instanceof CacheUpdate) {
                    $methodMetadata = new CacheUpdateMethodMetadata($method->class, $method->name);
                    $methodMetadata->type = $annotation->type;
                } else {

                    continue;
                }

                $methodMetadata->caches = $annotation->caches;
                if (!empty($annotation->key)) {
                    $methodMetadata->key = new Expression($annotation->key);
                }

                $hasCacheMetadata = true;
            }
        }

        return $hasCacheMetadata ? $methodMetadata : null;
    }
}
