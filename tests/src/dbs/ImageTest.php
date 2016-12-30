<?php
namespace IdOfThings;

class ImageTest extends BaseDbTest
{
    function testHash()
    {
        $guid = \PMVC\plug(TestPlug);
        $imageDb = $guid->getDb('image');
        $hash = $imageDb->getHash([]);
        $this->assertEquals(sha1($hash->json),$hash->hash);
    }
}
