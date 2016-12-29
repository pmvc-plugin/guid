<?php
namespace IdOfThings\dbs;

class manager extends \IdOfThings\BaseGuidDb
{
    private $_key;
    private $_guid;

    public function addNewKey($key)
    {
        $plugGuid = \PMVC\plug('guid'); 
        $gloKey = $plugGuid->getDb('GlobalKey');
        $gloGuid= $plugGuid->getDb('GlobalGuid');
        if (isset($gloKey[$key])) {
            return -1;
        }
        $newGuid = $plugGuid->gen();
        while (isset($gloGuid[$newGuid])) {
            $newGuid = $plugGuid->gen();
        }
        $gloGuid[$newGuid] = $key;
        $gloKey[$key] = $newGuid;
        return $newGuid;
    }

    public function removeKey($guid)
    {
        $plugGuid = \PMVC\plug('guid'); 
        $gloKey = $plugGuid->getDb('GlobalKey');
        $gloGuid= $plugGuid->getDb('GlobalGuid');
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
            $plugGuid = \PMVC\plug('guid'); 
            $gloKey = $plugGuid->getDb('GlobalKey');
            $gloGuid= $plugGuid->getDb('GlobalGuid');
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
            $this->_key = \PMVC\plug('guid')->
                getDb('GlobalKey');
        }
        return $this->_key;
    }

    public function getGuidDb()
    {
        if (empty($this->_guid)) {
            $this->_guid = \PMVC\plug('guid')->
                getDb('GlobalGuid');
        }
        return $this->_guid;
    }
}
