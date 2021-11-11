<?php

namespace IdOfThings;

use PMVC\PlugIn;
use PMVC\HashMap;

class FakeSSDB extends PlugIn
{
    private $_models;
    function getModel($name){
        if (!isset($this->_models[$name])) {
            $this->_models[$name] = new HashMap();
        }
        return $this->_models[$name];
    }
}
