<?php

namespace IdOfThings\dbs;

use IdOfThings\BaseGuidTempDb;

class checkout extends BaseGuidTempDb
{
    protected $groupKey='checkout';

    public function getNewKey($callback = null)
    {
        $guid = \PMVC\plug('guid');
        if (is_null($callback)) {
            $callback = $guid->get_default_exists($this);
        }
        $newGuid = $guid->gen(null, $callback);
        return $newGuid;
    }
}
