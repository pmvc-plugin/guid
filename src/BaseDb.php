<?php
namespace IdOfThings;

class BaseDb implements \ArrayAccess
{

    protected $default_key;
    protected $default_db;
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
        if(!empty($this->default_key)){
            $this->default_db = \PMVC\plug('guid')->getDb('GlobalKey')[$this->default_key];
        }
    }

    /**
     * ContainsKey
     *
     * @param string $k key 
     *
     * @return boolean
     */
    public function offsetExists($k)
    {
        if (empty($this->default_db)) {
            return;
        }
        return $this->db->hexists($this->default_db, $k);
    }

    /**
     * Get
     *
     * @param mixed $k key
     *
     * @return mixed 
     */
    public function &offsetGet($k=null)
    {
        $arr = false;
        if (empty($this->default_db)) {
            return $arr;
        }
        if (is_null($k)) {
	    $arr = $this->db->hgetall($this->default_db);
        } elseif (is_array($k)) { 
            $arr = $this->db->multi_hget($this->default_db, $k);
        } else {
            $arr = $this->db->hget($this->default_db, $k);
        }
        return $arr;
    }

    /**
     * Set 
     *
     * @param mixed $k key
     * @param mixed $v value 
     *
     * @return bool 
     */
    public function offsetSet($k, $v=null)
    {
        if (empty($this->default_db)) {
            return;
        }
        return $this->db->hset($this->default_db,$k,$v);
    }

    /**
     * Clean
     *
     * @param mixed $k key
     *
     * @return bool 
     */
    public function offsetUnset($k=null)
    {
        if (empty($this->default_db)) {
            return;
        }
        return $this->db->hdel($this->default_db, $k);
    }
}
