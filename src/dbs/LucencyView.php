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

    function getNewKey($site)
    {
        $key = date('Y_m_d_h').'_'.$site.'_';
        $newKey = null;
        $guid = \PMVC\plug('guid');
        $guid->gen(null, function($new) use ($key, &$newKey){
            $newKey = $key.$new; 
            if (isset($this[$newKey])) {
                return true;
            } else {
                return false;
            }
        });
        return $newKey;
    }
}
