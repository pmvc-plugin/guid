<?php

namespace IdOfThings;

use DomainException;
use PMVC\PlugIn;

abstract class GetModel extends PlugIn
{

    abstract function getNameSpace();
    abstract function getBaseModel();

    protected $models;

    private $_connected = false;

    /**
     * @param int    $id      Group guid
     * @param string $key     Group key
     * @param object $engine Custom engine
     */
    public function getModel($id, $key=null, $engine=null)
    {
        if (!$this->_connected) {
            throw new DomainException (
                'Server is not connected.'
            );
        }
        if (!isset($this->models[$id])) { // $this->models[$id] possible equal false, so can't use empty.
            $path = $this->getDir().'src/models/'.$key.'.php';
            if (\PMVC\realpath($path)) {
                \PMVC\l($path);
                $nameSpace = $this->getNameSpace();
                $class = $nameSpace.'\\models\\'.$key;
                if(class_exists($class)){
                    if (empty($engine)) {
                        $engine = $this->getEngine();
                    }
                    $this->models[$id] = new $class(
                        $engine,
                        $id 
                    );
                } else {
                    return !trigger_error($class .' not exists.');
                }
            } else {
                $this->models[$id] = $this->getFailback($id);
            }
        }
        return $this->models[$id];
    }

    public function getFailback($id)
    {
        $baseModel = $this->getBaseModel();
        return new $baseModel(
            $this->getEngine(),
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

    public function getEngine()
    {
        return $this[\PMVC\THIS];
    }
}
