<?php
namespace IdOfThings;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\manager';

class manager
{
    private $_key;
    private $_guid;

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
        $gloKey = $this->getKeyDb();
        $gloGuid= $this->getGuidDb();
        $gloKey[$newGuid] = $key;
        $gloGuid[$key] = $newGuid;
        return $newGuid;
    }

    public function remove($guid)
    {
        if ($this->hasGuid($guid)) {
            $gloKey = $this->getKeyDb();
            $gloGuid= $this->getGuidDb();
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
        $gloKey = $this->getKeyDb();
        $gloGuid= $this->getGuidDb();
        $oldKey = $this->getKey($guid);
        $gloKey[$guid] = $newKey;
        unset($gloGuid[$oldKey]);
        $gloGuid[$newKey] = $guid;
        return 0;
    }

    public function hasKey($key)
    {
        $db = $this->getGuidDb();
        return isset($db[$key]);
    }

    public function hasGuid($guid)
    {
        $db = $this->getKeyDb();
        return isset($db[$guid]);
    }

    public function getGuid($key)
    {
        if (!strlen($key)) {
            return !trigger_error('Key should not empty for extract guid.');
        }
        return $this->getGuidDb()[$key];
    }

    public function getGuids()
    {
        return $this->getGuidDb()[null];
    }

    public function getKey($guid)
    {
        if (!strlen($guid)) {
            return !trigger_error('Guid should not empty for extract key.');
        }
        return $this->getKeyDb()[$guid];
    }

    public function getKeys()
    {
        return $this->getKeyDb()[null];
    }

    public function getGuidDb()
    {
        if (empty($this->_guid)) {
            $this->_guid = $this->
                caller->
                getDb('GlobalGuid');
        }
        return $this->_guid;
    }

    public function getKeyDb()
    {
        if (empty($this->_key)) {
            $this->_key = $this->
                caller->
                getDb('GlobalKey');
        }
        return $this->_key;
    }

}
