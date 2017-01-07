<?php

namespace IdOfThings\dbs;

use IdOfThings\BaseGuidDb;

/**
 * Key: Year_Month_Day_Hour_Site_GUID
 * Value: [
 *  server: [] 
 *  clinet: []
 *  params: [] 
 * ]
 */
class LucencyView  extends BaseGuidDb
{
    protected $groupKey='lucency_view';

    function getNewKey($site, $callback = null, $timestamp = null)
    {
        if (is_null($timestamp)) {
            $timestamp = time();
        }

        $key = date('Y_m_d_h', $timestamp).'_'.$site.'_';
        if (is_null($callback)) {
            $callback = new LucencyViewExists(
                $key,
                $this
            );
        }

        $guid = \PMVC\plug('guid');
        $newguid = $guid->gen(null, $callback);
        return $key.$newguid;
    }
}

class LucencyViewExists
{
    private $_key;
    private $_caller;

    public function __construct($key, $self)
    {
        $this->_key = $key;
        $this->_caller = $self; 
    }

    public function __invoke($newGuid)
    {
        $key = $this->_key.$newGuid;
        return isset($this->_caller[$key]);
    }
}
