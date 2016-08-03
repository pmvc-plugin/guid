<?php
namespace IdOfThings;

class MinionsTest extends BaseDbTest
{
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

