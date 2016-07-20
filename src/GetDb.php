<?php
namespace IdOfThings;

abstract class GetDb extends \PMVC\PlugIn
{

    abstract function getNameSpace();
    abstract function getBaseDb();

    protected $dbs;

    private $_connected = false;

    /**
     * @param int    $id  group guid
     * @param string $key group key
     */
    public function getDb($id,$key=null)
    {
        if (!$this->_connected) {
            return !trigger_error('Server is not connected.');
        }
        if (empty($this->dbs[$id])) {
            $path = $this->getDir().'/src/dbs/'.$key.'.php';
            if (\PMVC\realpath($path)) {
                \PMVC\l($path);
                $nameSpace = $this->getNameSpace();
                $class = $nameSpace.'\\dbs\\'.$key;
                if(class_exists($class)){
                    $this->dbs[$id] = new $class(
                        $this['this'],
                        $id 
                    );
                } else {
                    return !trigger_error($class .' not exists.');
                }
            } else {
                $baseDb = $this->getBaseDb();
                $this->dbs[$id] = new $baseDb(
                    $this['this'],
                    $id
                );
            }
        }
        return $this->dbs[$id];
    }

    public function setConnected($bool = null)
    {
        if (!is_null($bool)) {
            $this->_connected = $bool;
        }
        return $this->_connected;
    }
}
