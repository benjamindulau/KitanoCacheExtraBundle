<?php

namespace Ano\Bundle\KitanoCacheExtraBundle;

class SerializedCacheValue
{
    public $type;
    public $data;

    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }
}