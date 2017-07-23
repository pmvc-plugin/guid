<?php
namespace IdOfThings;

use DomainException;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\guid';

class guid extends \PMVC\PlugIn
{
    private $dbs;
    private $_privateDbPlugin = null;

    /**
     * @parameters string guidDb Default db plugin.
     * @parameters string privateDb Private db plugin.
     */
    public function init()
    {
        $guid = new BigIntGuid(); 
        $this->setDefaultAlias($guid);
        if (!isset($this['privateDb'])) {
            $this['privateDb'] = 'guid_private_db';
        }
    }

    private function _getPrivateDb($key)
    {
        $private = $this->getPrivateDbPlugin();
        if ($private) {
            $db = $private->getDb($key, $key);
            if ($db) {
                $this->dbs[$key] = $db;

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function getPrivateDbPlugin()
    {
        if (is_null($this->_privateDbPlugin)) {
           if (\PMVC\exists($this['privateDb'],'plug')) {
                $this->_privateDbPlugin = \PMVC\plug($this['privateDb']);
           } else {
                $this->_privateDbPlugin = false; 
           }
        }
        return $this->_privateDbPlugin;
    }

    private function _getPublicDb($key)
    {
        $class =  __NAMESPACE__.'\\dbs\\'.$key;
        if (!class_exists($class)) {
            return !trigger_error(
                '[GUID] Db not found ['.$class.']',
                E_USER_WARNING
            );
        }
        $storage = $this->getStorage();
        if (empty($storage)) {
            return !trigger_error(
                '[GUID] Get storage failed.',
                E_USER_WARNING
            );
        }
        $this->dbs[$key] = new $class($storage);
        return true;
    }

    public function getDb($key)
    {
        if(empty($this->dbs[$key])){
            if (!$this->_getPrivateDb($key)) {
                $this->_getPublicDb($key);
            }
        }
        return $this->dbs[$key];
    }

    public function getStorage()
    {
        if (empty($this['guidDb'])) {
            throw new DomainException (
                'Default db plugin not setted. "guidDb"'
            );
        }
        return \PMVC\plug($this['guidDb']);
    }
}
