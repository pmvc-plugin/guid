<?php
namespace IdOfThings;

use IdOfThings\dbs\LucencyActionExists;

class LucencyActionTest extends BaseDbTest
{
    function testExists()
    {
        $guid = \PMVC\plug(TestPlug);
        $db = $guid->getDb('LucencyAction');
        $fakeKey = 'fakeKey';
        $exists = new LucencyActionExists(
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
        $db = $guid->getDb('LucencyAction');
        $now = time();
        $getNewGuid = null;
        $site = 'fakeSite';
        $actual = $db->getNewKey($site, function($new) use (&$getNewGuid) {
            $getNewGuid = $new;
        }, $now);
        $expected = date('Y_m_d_H', $now).'_'.$site.'_'.$getNewGuid;
        $this->assertEquals($expected, $actual);
    }
}
