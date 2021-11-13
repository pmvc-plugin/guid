<?php

namespace IdOfThings;

use ArrayAccess;

/**
 * Design idea.
 *
 * 1. each modle could assign with different engine
 * 2. could have multi instance.
 * 3. modelKey use for code (php code).
 * 4. modelTable use in storage (Aka the real table name).
 * 5. Both moelKey and modelTable could remap to new name,
 *    and they could defined inside guid plugin. ($guid['tables']['xxx'] and $guid['keys']['xxx'])
 * 6. should only GlobalGuidKey and GlobalKeyGuid define start from modelTable.
 * 7. Other models should defined from modelKey and they'll query modelTable from GlobalKeyGuid.
 * 8. When models get modelTable, the modelTable will pass to engineModel.
 *
 */
class BaseModel implements ArrayAccess
{
    protected $modelKey;
    protected $modelTable;
    protected $engineModel;

    public function __construct($engine, $modelTable = null)
    {
        $pGuid = \PMVC\plug('guid');
        if (!empty($this->modelTable)) {
            $tables = explode('_', $this->modelTable);
            array_unshift($tables, 'tables');

            // search guid['tables']['xxx']
            $this->modelTable = \PMVC\value($pGuid, $tables, $this->modelTable);
        } elseif (!empty($this->modelKey)) {
            $keys = explode('_', $this->modelKey);
            array_unshift($keys, 'keys');

            // search guid['keys']['xxx']
            $this->modelKey = \PMVC\value($pGuid, $keys, $this->modelKey);

            $this->modelTable = \PMVC\plug('guid')
                ->manager()
                ->getGuid($this->modelKey);
        }
    }

    /**
     * Really name in database table name
     */
    public function getTable()
    {
        return $this->modelTable;
    }

    /**
     * get the engine's model
     */
    public function getEngineModel()
    {
        return $this->engineModel;
    }

    public function setEngineModel($engineModel)
    {
        $this->engineModel = $engineModel;
        if ($this->engineModel) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get composite key
     */
    public function getCompositeKey($id)
    {
        return $this->getTable() . '_' . $id;
    }

    /**
     * Insert
     */
    public function insert($k, $v)
    {
        if ($this->offsetExists($k)) {
            return !trigger_error(
                '[Insert Fail] Key already exists.' .
                    ' Table: ' .
                    $this->getTable() .
                    ' Key: ' .
                    $k,
                E_USER_WARNING
            );
        }
        return $this->offsetSet($k, $v);
    }

    /**
     * ContainsKey
     *
     * @param string $k key
     *
     * @return boolean
     */
    public function offsetExists($k)
    {
        return $this->engineModel->offsetExists($k);
    }

    /**
     * Get
     *
     * @param mixed $k key
     *
     * @return mixed
     */
    public function &offsetGet($k = null)
    {
        $result = &$this->engineModel->offsetGet($k);
        return $result;
    }

    /**
     * Set
     *
     * @param mixed $k key
     * @param mixed $v value
     *
     * @return bool
     */
    public function offsetSet($k, $v = null)
    {
        return $this->engineModel->offsetSet($k, $v);
    }

    /**
     * Clean
     *
     * @param mixed $k key
     *
     * @return bool
     */
    public function offsetUnset($k = null)
    {
        return $this->engineModel->offsetUnset($k);
    }

    /**
     * Super Call
     */
    public function __call($method, $args)
    {
        $func = [$this->engineModel, $method];
        if (is_callable($func)) {
            return call_user_func_array($func, $args);
        }
    }
}
