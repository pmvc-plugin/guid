<?php
namespace IdOfThings;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\manager';

class manager
{
    private $_guid;
    private $_key;

    public function __invoke()
    {
        return $this;
    }

    public function addNewKey($key)
    {
        if (!strlen($key)) {
            return !trigger_error('Key was empty.');
        }
        if ($this->hasKey($key)) {
            return !trigger_error('Key already exits. ['.$key.']');
        }
        $newGuid = $this->caller->gen(
            null,
            function ($newGuid) {
                return $this->hasGuid($newGuid);
            }
        );
        $gloGuid= $this->_getGuidDb();
        $gloKey = $this->_getKeyDb();
        $gloKey[$newGuid] = $key;
        $gloGuid[$key] = $newGuid;
        return $newGuid;
    }

    public function remove($guid)
    {
        if ($this->hasGuid($guid)) {
            $gloGuid= $this->_getGuidDb();
            $gloKey = $this->_getKeyDb();
            $key = $this->getKey($guid);
            unset($gloGuid[$key]);
            unset($gloKey[$guid]);
            return 0;
        } else {
            return !trigger_error('Guid not exits. ['.$guid.']');
        }
    }

    public function changeKey($guid, $newKey)
    {
        if (!strlen($newKey)) {
            return !trigger_error('Key was empty.');
        }
        if ($this->hasKey($newKey)) {
            return !trigger_error('Key already exits. ['.$newKey.']');
        }
        if (!$this->hasGuid($guid)) {
            return !trigger_error('Guid not exits. ['.$guid.']');
        }
        $gloGuid= $this->_getGuidDb();
        $gloKey = $this->_getKeyDb();
        $oldKey = $this->getKey($guid);
        $gloKey[$guid] = $newKey;
        unset($gloGuid[$oldKey]);
        $gloGuid[$newKey] = $guid;
        return 0;
    }

    public function hasGuid($guid)
    {
        $db = $this->_getKeyDb();
        return isset($db[$guid]);
    }

    public function hasKey($key)
    {
        $db = $this->_getGuidDb();
        return isset($db[$key]);
    }

    public function getGuid($key)
    {
        if (!strlen($key)) {
            return !trigger_error('Key should not empty for extract guid.');
        }
        return $this->_getGuidDb()[$key];
    }

    public function getGuids()
    {
        return $this->_getGuidDb()[null];
    }

    public function getKey($guid)
    {
        if (!strlen($guid)) {
            return !trigger_error('Guid should not empty for extract key.');
        }
        return $this->_getKeyDb()[$guid];
    }

    public function getKeys()
    {
        return $this->_getKeyDb()[null];
    }

    private function _getGuidDb()
    {
        if (empty($this->_guid)) {
            $this->_guid = $this->
                caller->
                getDb('GlobalKeyGuid');
        }
        return $this->_guid;
    }

    private function _getKeyDb()
    {
        if (empty($this->_key)) {
            $this->_key = $this->
                caller->
                getDb('GlobalGuidKey');
        }
        return $this->_key;
    }

}
