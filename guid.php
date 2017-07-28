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

    private function _getPrivateDbPlugin()
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

    private function _getPrivateDb($key, $storage=null)
    {
        $private = $this->_getPrivateDbPlugin();
        if ($private) {
            $db = $private->getDb($key, $key, $storage);
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

    private function _getPublicDb($key, $storage=null)
    {
        $class =  __NAMESPACE__.'\\dbs\\'.$key;
        if (!class_exists($class)) {
            return !trigger_error(
                '[GUID] Db not found ['.$class.']',
                E_USER_WARNING
            );
        }
        if (empty($storage)) {
            $storage = $this->getStorage();
        }
        $this->dbs[$key] = new $class($storage);
        return true;
    }

    public function getDb($key, $storage=null)
    {
        if(empty($this->dbs[$key])){
            if (!$this->_getPrivateDb($key, $storage)) {
                $this->_getPublicDb($key, $storage);
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
        $storage = \PMVC\plug($this['guidDb']);
        if (empty($storage)) {
            return !trigger_error(
                '[GUID] Get storage failed.',
                E_USER_WARNING
            );
        }
        return $storage;
    }
}
