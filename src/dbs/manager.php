<?php
namespace IdOfThings\dbs;

class manager
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getFields()
    {
    }

    public function setFields($name, $fields)
    {
        if (!is_array($arr)) {
            return false;
        }
        $fields_guid = array();
        foreach ($arr as $k) {
            $guid = $this->getGuid($k);
            if ($k) {
                $fields_guid[] = $k;
            }
        }
        $page = $this->getGuid('page');
        $json = json_encode($fields_guid);
        $this->db->hset($page, $name, $json);
    }

    public function addNewKey($key)
    {
        if ($this->isKeyExists($key)) {
            return -1;
        }
        $oguid = \PMVC\plug('guid');
        $newGuid = $oguid->gen();
        while ($this->isGuidExists($newGuid)) {
            $newGuid = $oguid->gen();
        }
        $this->db->hset('guid', $newGuid, $key);
        $this->db->hset('keys', $key, $newGuid);
        return $newGuid;
    }

    public function removeKey($guid)
    {
        $data = $this->get($guid);
        if (!empty($data['guid'])) {
            $this->db->hdel('guid', $data['guid']);
        }
        if (!empty($data['key'])) {
            $this->db->hdel('keys', $data['key']);
        }
        return 0;
    }

    public function isKeyExists($key)
    {
        return $this->db->hexists('keys', $key);
    }

    public function isGuidExists($guid)
    {
        return $this->db->hexists('guid', $guid);
    }

    public function changeKey($guid, $key)
    {
        if (!strlen($key)) {
            return false;
        } else {
            $oldKey = $this->db->hget('guid', $guid);
            $this->db->hset('guid', $guid, $key);
            $this->db->hdel('keys', $oldKey);
            $this->db->hset('keys', $key, $guid);
        }
    }

    public function get($guid)
    {
        $key = $this->db->hget('guid', $guid);
        $guid_by_key =$this->db->hget('keys', $key);
        $arr = array(
            'guid'=>$guid_by_key
            ,'key'=>$key
        );
        return $arr;
    }

    public function getAll($id="guid")
    {
        return $this->db->hgetall($id);
    }

    public function getKey($guid)
    {
        return $this->db->hget('guid', $guid);
    }

    public function getGuid($key)
    {
        return $this->getOneGuid($key);
    }

    public function getOneGuid($key)
    {
        return $this->db->hget('keys', $key);
    }

    public function getAllGuids($arr_keys)
    {
        return $this->db->multi_hget('keys', $arr_keys);
    }
}
