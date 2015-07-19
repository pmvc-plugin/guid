<?php
namespace IdOfThings\dbs;

class manager extends \IdOfThings\BaseGuidDb
{
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
}
