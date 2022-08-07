<?php 
declare( strict_types = 1 );
namespace Avature\Utils;

use Cache AS BaseCache;

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

    public function getAllKeys()
    {
        BaseCache::flush();
        return BaseCache::getStore()->getFilesystem();
        ache::forget('key');
    }

    
}