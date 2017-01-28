<?php
namespace IdOfThings;

use IdOfThings\dbs\LucencyViewExists;

class LucencyViewTest extends BaseDbTest
{
    function testExists()
    {
        $guid = \PMVC\plug(TestPlug);
        $db = $guid->getDb('LucencyView');
        $fakeKey = 'fakeKey';
        $exists = new LucencyViewExists(
            $fakeKey,
            $db
        );
        $id = 'fakeGuid';
        $this->assertFalse($exists($id));
        $db[$fakeKey.$id] = 1;
        $this->assertTrue($exists($id));
    }

    function testGetNewKey()
    {
        $guid = \PMVC\plug(TestPlug);
        $db = $guid->getDb('LucencyView');
        $now = time();
        $getNewGuid = null;
        $site = 'fakeSite';
        $actual = $db->getNewKey($site, function($new) use (&$getNewGuid) {
            $getNewGuid = $new;
        }, $now);
        $expected = $site.'_'.date('Y_m_d_H', $now).'_'.$getNewGuid;
        $this->assertEquals($expected, $actual);
    }
}
