<?php

namespace IdOfThings\models;

use IdOfThings\BaseGuidTempModel;

class checkout extends BaseGuidTempModel
{
    protected $modelKey='checkout';

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
