<?php

namespace IdOfThings\models;

use IdOfThings\BaseGuidModel;

/**
 * Key: Year_Month_Day_Hour_Site_GUID
 * Value: [
 *  server: [] 
 *  clinet: []
 *  params: [] 
 * ]
 */
class LucencyAction  extends BaseGuidModel
{
    protected $modelKey='lucency_action';

    function getNewKey($site, $callback = null, $timestamp = null)
    {
        if (is_null($timestamp)) {
            $timestamp = time();
        }

        $key = $site.'_'.date('Y_m_d_H', $timestamp).'_';
        if (is_null($callback)) {
            $callback = new LucencyActionExists(
                $key,
                $this
            );
        }

        $guid = \PMVC\plug('guid');
        $newguid = $guid->gen(null, $callback);
        return $key.$newguid;
    }
}

class LucencyActionExists
{
    private $_key;
    private $_model;

    public function __construct($key, $model)
    {
        $this->_key = $key;
        $this->_model = $model; 
    }

    public function __invoke($newGuid)
    {
        $key = $this->_key.$newGuid;
        return isset($this->_model[$key]);
    }
}
