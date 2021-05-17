<?php

namespace IdOfThings;

use PMVC\TestCase;

class BaseDbTest extends TestCase
{
    private $plug = TestPlug;
    function pmvc_setup()
    {
        \PMVC\unplug($this->plug);
        $db_plug = 'fake_ssdb'; 
        \PMVC\unplug($db_plug);
        $fake_db = __NAMESPACE__.'\FakeSSDB';
        \PMVC\option('set', 'PLUGIN', ['guid'=>['guidDb'=>$db_plug]]);
        \PMVC\plug($db_plug, [ 
            _CLASS => $fake_db
        ]);
    }
}
