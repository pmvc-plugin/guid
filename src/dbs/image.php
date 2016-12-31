<?php
namespace IdOfThings\dbs;
class image extends \IdOfThings\BaseGuidDb
{

    protected $groupKey='image';
    private $_cdn_static_version='2016123101';

    /**
     * get one
     */
    public function &offsetGet($id=null)
    {
        return $this->db->offsetGet($id);
    }

    /**
     * Delete
     */
    public function offsetUnset($id=null)
    {
        unset($this->db[$id]);
    }

    /**
     * add 
     */
    function addImg($url,$data=array()){
        if (!empty($url)) {
            $data['url'] = $url;
        }
        $data['url'] = (string)$data['url'];
        $hash = $this->getHash($data);
        $cache = 86400;
        if( !empty($data['cache']) && $data['cache']>$cache){
            $cache = $data['cache'];
        }
        // store
        $this->db->cache = $cache;
        $this->db[$hash->id] = $hash->json;
        $this->db->cache = null;
        return $hash->hash;
    }

    function getHash(array $data){
        $data[]=$this->_cdn_static_version;
        $return = new \stdClass();
        uksort($data, 'strnatcmp');
        $return->json = json_encode($data);
        $return->hash = sha1($return->json);
        $return->id = $this->getCompositeKey($return->hash);
        return $return;
    }

}
