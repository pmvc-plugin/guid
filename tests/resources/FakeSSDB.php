<?php

namespace IdOfThings;

use PMVC\PlugIn;
use PMVC\HashMap;

class FakeSSDB extends PlugIn
{
    private $_dbs;
    function getdb($name){
        if (!isset($this->_dbs[$name])) {
            $this->_dbs[$name] = new HashMap();
        }
        return $this->_dbs[$name];
    }
}
