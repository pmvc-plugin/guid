<?php
namespace IdOfThings;

class BaseGuidDb implements \ArrayAccess
{

    protected $groupKey;
    protected $groupDb;
    public $db;

    public function __construct($db)
    {
        if(!empty($this->groupKey)){
            $this->groupDb = \PMVC\plug('guid')->getDb('GlobalKey')[$this->groupKey];
        }
        $this->db = $db->getDb($this->groupDb,$this->groupKey);
    }

    /**
     * Really name in database table name
     */
     public function getTable()
     {
        return $this->groupDb;
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
        return $this->db->offsetExists($k);
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
        $result =& $this->db->offsetGet($k);
        return $result;
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
        return $this->db->offsetSet($k, $v);
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
        return $this->db->offsetUnset($k);
    }

    /**
     * Super Call
     */
     public function __call($method, $args)
     {
         $func = array($this->db,$method);
         if (is_callable($func)) {
            return call_user_func_array(
                $func,
                $args
            );
         }
     }
}
