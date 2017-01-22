<?php

namespace IdOfThings;

use PHPUnit_Framework_TestCase;

class BaseDbTest extends PHPUnit_Framework_TestCase
{
    private $plug = TestPlug;
    function setup()
    {
        \PMVC\unplug($this->plug);
        $db_plug = 'fake_ssdb'; 
        \PMVC\unplug($db_plug);
        $fake_db = __NAMESPACE__.'\FakeSSDB';
        \PMVC\option('set','GUID_DB',$db_plug);
        \PMVC\plug($db_plug,array(
            _CLASS => $fake_db
        ));
    }
}
