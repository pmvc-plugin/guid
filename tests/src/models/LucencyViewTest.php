<?php
namespace IdOfThings;

use IdOfThings\models\LucencyViewExists;

class LucencyViewTest extends BaseModelTest
{
    function testExists()
    {
        $guid = \PMVC\plug(TestPlug);
        $model = $guid->getModel('LucencyView');
        $fakeKey = 'fakeKey';
        $exists = new LucencyViewExists(
            $fakeKey,
            $model
        );
        $id = 'fakeGuid';
        $this->assertFalse($exists($id));
        $model[$fakeKey.$id] = 1;
        $this->assertTrue($exists($id));
    }

    function testGetNewKey()
    {
        $guid = \PMVC\plug(TestPlug);
        $model = $guid->getModel('LucencyView');
        $now = time();
        $getNewGuid = null;
        $site = 'fakeSite';
        $actual = $model->getNewKey($site, function($new) use (&$getNewGuid) {
            $getNewGuid = $new;
        }, $now);
        $expected = $site.'_'.date('Y_m_d_H', $now).'_'.$getNewGuid;
        $this->assertEquals($expected, $actual);
    }
}
