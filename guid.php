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
        $this['GUID_DB'] = \PMVC\plug('get')->get('GUID_DB');
    }

    public function getDb($key)
    {
        if(empty($this->dbs[$key])){
            $class =  __NAMESPACE__.'\dbs\\'.$key;
            if (!class_exists($class)) {
                return !trigger_error('guid db not found ['.$class.']');
            }
            $this->dbs[$key] = new $class(
                $this->getStorage()
            );
        }
        return $this->dbs[$key];
    }

    public function getStorage()
    {
        if (empty($this['GUID_DB'])) {
            trigger_error('Need putenv "GUID_DB"');
        }
        return \PMVC\plug($this['GUID_DB']);
    }
}
