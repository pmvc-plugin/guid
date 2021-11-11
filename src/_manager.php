<?php
namespace IdOfThings;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\manager';

class manager
{
    private $_guid;
    private $_key;

    public function __invoke()
    {
        return $this;
    }


    /**
     * assign $newGuid for import data
     */
    public function addNewKey($key, $newGuid = null)
    {
        if (!strlen($key)) {
            return !trigger_error('Key was empty.');
        }
        if ($this->hasKey($key)) {
            return !trigger_error('Key already exits. [' . $key . ']');
        }
        if (is_null($newGuid)) {
            $newGuid = $this->caller->gen(null, function ($newGuid) {
                return $this->hasGuid($newGuid);
            });
        }
        $gloGuid = $this->_getGuidModel();
        $gloKey = $this->_getKeyModel();
        $gloKey[$newGuid] = $key;
        $gloGuid[$key] = $newGuid;
        return $newGuid;
    }

    public function remove($guid, $noCheck = null)
    {
        if ($this->hasGuid($guid)) {
            $gloGuid = $this->_getGuidModel();
            $gloKey = $this->_getKeyModel();
            $key = $this->getKey($guid);
            unset($gloGuid[$key]);
            unset($gloKey[$guid]);
            return 0;
        } else {
            if (empty($noCheck)) {
                return !trigger_error('Guid not exits. [' . $guid . ']');
            }
        }
    }

    public function changeKey($guid, $newKey)
    {
        if (!strlen($newKey)) {
            return !trigger_error('Key was empty.');
        }
        if ($this->hasKey($newKey)) {
            return !trigger_error('Key already exits. [' . $newKey . ']');
        }
        if (!$this->hasGuid($guid)) {
            return !trigger_error('Guid not exits. [' . $guid . ']');
        }
        $gloGuid = $this->_getGuidModel();
        $gloKey = $this->_getKeyModel();
        $oldKey = $this->getKey($guid);
        $gloKey[$guid] = $newKey;
        unset($gloGuid[$oldKey]);
        $gloGuid[$newKey] = $guid;
        return 0;
    }

    public function hasGuid($guid)
    {
        $model = $this->_getKeyModel();
        return isset($model[$guid]);
    }

    public function hasKey($key)
    {
        $model = $this->_getGuidModel();
        return isset($model[$key]);
    }

    public function getGuid($key)
    {
        if (!strlen($key)) {
            return !trigger_error('Key should not empty for extract guid.');
        }
        return $this->_getGuidModel()[$key];
    }

    public function getGuids($key = null)
    {
        // key for magic function (such as \PMVC\get)
        return $this->_getGuidModel()[$key];
    }

    public function getKey($guid)
    {
        if (!strlen($guid)) {
            return !trigger_error('Guid should not empty for extract key.');
        }
        return $this->_getKeyModel()[$guid];
    }

    public function getKeys($guid = null)
    {
        // guid for magic function (such as \PMVC\get)
        return $this->_getKeyModel()[$guid];
    }

    private function _getGuidModel()
    {
        if (empty($this->_guid)) {
            $this->_guid = $this->caller->getModel('GlobalKeyGuid');
        }
        return $this->_guid;
    }

    private function _getKeyModel()
    {
        if (empty($this->_key)) {
            $this->_key = $this->caller->getModel('GlobalGuidKey');
        }
        return $this->_key;
    }
}
