<?php
namespace IdOfThings;

class ImageTest extends BaseDbTest
{
    function testHash()
    {
        $guid = \PMVC\plug(TestPlug);
        $imageDb = $guid->getDb('image');
        $hash = $imageDb->getHash([]);
        $this->assertEquals(md5($hash->json),$hash->md5);
    }
}
