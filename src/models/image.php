<?php

namespace IdOfThings\models;

use IdOfThings\BaseGuidModel;

class image extends BaseGuidModel
{

    protected $modelKey='image';
    private $_cdn_static_version='2016123101';
    const cache = 'cache';

    /**
     * add 
     */
    function addImg($url, $data=[])
    {
        // handle url
        if (!empty($url)) {
            $data['url'] = $url;
        }
        $data['url'] = (string)$data['url'];

        // store
        $hash = $this->getHash($data);
        $this->engineModel[$hash->id] = $hash->json;
        $this->setExpire($hash->id, $hash->cache);
        return $hash->hash;
    }

    private function _setDefaultCache($data)
    {
        // handle cache
        $cache = 86400 * 365;
        if(empty($data[self::cache])) {
            $data[self::cache] = $cache;
        }
        return $data;
    }

    function getHash(array $data)
    {
        $data[]=$this->_cdn_static_version;
        $data = $this->_setDefaultCache($data);
        $return = new \stdClass();
        uksort($data, 'strnatcmp');
        $return->json = json_encode($data);
        $return->hash = sha1($return->json);
        $return->id = $this->getCompositeKey($return->hash);
        $return->cache = $data[self::cache];
        return $return;
    }

}
