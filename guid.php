<?php
namespace IdOfThings;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\guid';

class guid extends \PMVC\PlugIn
{
    private $dbs;
    private $db_key_map;
    public function init()
    {
        $guid = new BigIntGuid(); 
        $this->setDefaultAlias($guid);
    }

    public function getDb($key)
    {
        if(empty($this->dbs[$key])){
            $class =  __NAMESPACE__.'\dbs\\'.$key;
            $this->dbs[$key] = new $class($this->getStorage());
        }
        return $this->dbs[$key];
    }

    public function getStorage()
    {
        $guid_db = getenv('GUID_DB'); 
        return \PMVC\plug($guid_db);
    }

    public function getDbKey($key)
    {
        if(empty($this->db_key_map[$key])){
            $this->db_key_map[$key] =$this->getStorage()->hget('keys',$key);
        }
        return $this->db_key_map[$key];
    }
}
