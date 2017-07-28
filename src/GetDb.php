<?php
namespace IdOfThings;

abstract class GetDb extends \PMVC\PlugIn
{

    abstract function getNameSpace();
    abstract function getBaseDb();

    protected $dbs;

    private $_connected = false;

    /**
     * @param int    $id      Group guid
     * @param string $key     Group key
     * @param object $storage Custom storage
     */
    public function getDb($id, $key=null, $storage=null)
    {
        if (!$this->_connected) {
            return !trigger_error('Server is not connected.');
        }
        if (!isset($this->dbs[$id])) { // $this->dbs[$id] possible equal false, so can't use empty.
            $path = $this->getDir().'src/dbs/'.$key.'.php';
            if (\PMVC\realpath($path)) {
                \PMVC\l($path);
                $nameSpace = $this->getNameSpace();
                $class = $nameSpace.'\\dbs\\'.$key;
                if(class_exists($class)){
                    if (empty($storage)) {
                        $storage = $this->getStorage();
                    }
                    $this->dbs[$id] = new $class(
                        $storage,
                        $id 
                    );
                } else {
                    return !trigger_error($class .' not exists.');
                }
            } else {
                $this->dbs[$id] = $this->getFailback($id);
            }
        }
        return $this->dbs[$id];
    }

    public function getFailback($id)
    {
        $baseDb = $this->getBaseDb();
        return new $baseDb(
            $this->getStorage(),
            $id
        );
    }

    public function setConnected($bool = null)
    {
        if (!is_null($bool)) {
            $this->_connected = $bool;
        }
        return $this->_connected;
    }

    public function getStorage()
    {
        return $this[\PMVC\THIS];
    }
}
