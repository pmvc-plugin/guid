<?php

namespace IdOfThings\dbs;

use IdOfThings\BaseGuidDb;

class image extends BaseGuidDb
{

    protected $groupKey='image';
    private $_cdn_static_version='2016123101';

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

        // handle cache
        $cache = 86400 * 365;
        if(empty($data['cache'])) {
            $data['cache'] = $cache;
        }

        // store
        $hash = $this->getHash($data);
        $this->db[$hash->id] = $hash->json;
        $this->setExpire($hash->id, $data['cache']);
        return $hash->hash;
    }

    function getHash(array $data)
    {
        $data[]=$this->_cdn_static_version;
        $return = new \stdClass();
        uksort($data, 'strnatcmp');
        $return->json = json_encode($data);
        $return->hash = sha1($return->json);
        $return->id = $this->getCompositeKey($return->hash);
        return $return;
    }

}
