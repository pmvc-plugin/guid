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
        $gloKey = $this->getKeyDb();
        $gloGuid= $this->getGuidDb();
        if (isset($gloKey[$key])) {
            return -1;
        }
        $newGuid = $this->caller->gen(
            null,
            function ($newGuid) use ($gloGuid) {
                return isset($gloGuid[$newGuid]);
            }
        );
        $gloGuid[$newGuid] = $key;
        $gloKey[$key] = $newGuid;
        return $newGuid;
    }

    public function removeKey($guid)
    {
        $gloKey = $this->getKeyDb();
        $gloGuid= $this->getGuidDb();
        if(isset($gloGuid[$guid])){
            $key = $gloGuid[$guid];
            unset($gloGuid[$guid]);
            unset($gloKey[$key]);
        }        
        return 0;
    }

    public function changeKey($guid, $newKey)
    {
        if (!strlen($newKey)) {
            return false;
        } else {
            $gloKey = $this->getKeyDb();
            $gloGuid= $this->getGuidDb();
            $oldKey = $gloGuid[$guid];
            $gloGuid[$guid] = $newKey;
            unset($gloKey[$oldKey]);
            $gloKey[$newKey] = $guid;
        }
    }

    public function getGuid($key)
    {
        return $this->getKeyDb()[$key];
    }

    public function hasGuid($key)
    {
        $db = $this->getKeyDb();
        return isset($db[$key]);
    }

    public function getKey($guid)
    {
        return $this->getGuidDb()[$guid];
    }

    public function hasKey($guid)
    {
        $db = $this->getGuidDb();
        return isset($db[$guid]);
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

    public function getGuidDb()
    {
        if (empty($this->_guid)) {
            $this->_guid = $this->
                caller->
                getDb('GlobalGuid');
        }
        return $this->_guid;
    }
}
