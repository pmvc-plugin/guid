<?php
namespace IdOfThings;

use PHPUnit_Framework_TestCase;

class BaseDbTest extends PHPUnit_Framework_TestCase
{
    function setup()
    {
        $fake_db = __NAMESPACE__.'\FakeSSDB';
        $db_plug = 'fake_ssdb'; 
        \PMVC\option('set','GUID_DB',$db_plug);
        \PMVC\plug($db_plug,array(
            _CLASS => $fake_db
        ));
    }
}
