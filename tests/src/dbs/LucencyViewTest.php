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
        $guid = 'fakeGuid';
        $this->assertFalse($exists($guid));
        $db[$fakeKey.$guid] = 1;
        $this->assertTrue($exists($guid));
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
        $expected = date('Y_m_d_h', $now).'_'.$site.'_'.$getNewGuid;
        $this->assertEquals($expected, $actual);
    }
}
