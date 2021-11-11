<?php

namespace IdOfThings;

use PMVC\TestCase;

class BaseModelTest extends TestCase
{
    private $plug = TestPlug;
    function pmvc_setup()
    {
        \PMVC\unplug($this->plug);
        $fakeEnginePlugIn = 'fake_ssdb'; 
        \PMVC\unplug($fakeEnginePlugIn);
        $fakeEngineClass = __NAMESPACE__.'\FakeSSDB';
        \PMVC\option('set', 'PLUGIN', ['guid'=>['guidEngine'=>$fakeEnginePlugIn]]);
        \PMVC\plug($fakeEnginePlugIn, [ 
            _CLASS => $fakeEngineClass
        ]);
    }
}
