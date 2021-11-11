<?php
namespace IdOfThings;

class MinionsTest extends BaseModelTest
{
    function testGetMinionsDb()
    {
        $guid = \PMVC\plug(TestPlug);
        $minionsModel = $guid->getModel('minions');
        ob_start();
        print_r($minionsModel);
        $output = ob_get_contents();
        ob_end_clean();
        $this->haveString('minions',$output);
    }
}

