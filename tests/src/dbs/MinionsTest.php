<?php
namespace IdOfThings;
use PHPUnit_Framework_TestCase;
use PMVC;

class MinionsTest extends PHPUnit_Framework_TestCase
{

    function setup()
    {
        $fake_db = __NAMESPACE__.'\FakeSSDB';
        $db_plug = 'fake_ssdb'; 
        PMVC\option('set','GUID_DB',$db_plug);
        PMVC\plug($db_plug,array(
            _CLASS => $fake_db
        ));
    }

    function testGetMinionsDb()
    {
        $guid = \PMVC\plug(TestPlug);
        $minionsDb = $guid->getDb('minions');
        ob_start();
        print_r($minionsDb);
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains('minions',$output);
    }
}

