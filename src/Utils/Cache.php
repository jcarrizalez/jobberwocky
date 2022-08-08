<?php

declare(strict_types=1);

namespace Avature\Utils;

use Cache as BaseCache;

class Cache
{
    public function get($key)
    {
        return BaseCache::get($key);
    }

    public function put($key, $data, $minutes = 60)
    {
        BaseCache::put($key, $data, $minutes);
    }
}
