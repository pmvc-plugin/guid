<?php
namespace IdOfThings;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\guid';

class guid extends \PMVC\PlugIn
{
    private $dbs;
    public function init()
    {
        $guid = new BigIntGuid(); 
        $this->setDefaultAlias($guid);
    }

    public function getDb($key)
    {
        if(empty($this->dbs[$key])){
            $class =  __NAMESPACE__.'\dbs\\'.$key;
            $this->dbs[$key] = new $class(
                $this->getStorage()
            );
        }
        return $this->dbs[$key];
    }

    public function getStorage()
    {
        $guid_db = getenv('GUID_DB'); 
        if (empty($guid_db)) {
            trigger_error('Need putenv "GUID_DB"');
        } else {
            return \PMVC\plug($guid_db);
        }
    }

}
