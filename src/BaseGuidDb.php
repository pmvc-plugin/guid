<?php
namespace IdOfThings;

use ArrayAccess;

class BaseGuidDb implements ArrayAccess
{

    protected $groupKey;
    protected $groupTable;
    public $db;

    public function __construct($db)
    {
        if(!empty($this->groupKey)){
            $this->groupTable = \PMVC\plug('guid')->getDb('GlobalKey')[$this->groupKey];
        }
        $this->db = $db->getDb($this->groupTable, $this->groupKey);
        if (empty($this->db)) {
            return !trigger_error('Init guid db failed.');
        }
    }

    /**
     * Really name in database table name
     */
     public function getTable()
     {
        return $this->groupTable;
     }

     /**
      * Get composite key
      */
     public function getCompositeKey($id)
     {
         return $this->getTable().'_'.$id;
     }

     /**
      * Insert
      */
     public function insert($k, $v)
     {
        if ($this->offsetExists($k)) {
            return !trigger_error(
                '[Insert Fail] Key already exists.'.
                ' Table: '. $this->getTable().
                ' Key: '.$k,
                E_USER_WARNING
            );
        }
        return $this->offsetSet($k, $v);
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
