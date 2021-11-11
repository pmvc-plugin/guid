<?php
namespace IdOfThings;

class ImageTest extends BaseModelTest
{
    function testHash()
    {
        $guid = \PMVC\plug(TestPlug);
        $imageModel = $guid->getModel('image');
        $hash = $imageModel->getHash([]);
        $this->assertEquals(sha1($hash->json),$hash->hash);
    }
}
