<?php

namespace IdOfThings;

use PMVC;

class GuidTest extends BaseDbTest
{
    private $plug = TestPlug;
    function testPlugin()
    {
        ob_start();
        print_r(PMVC\plug($this->plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->plug,$output);
    }


    function testGenId()
    {
        $id = PMVC\plug($this->plug)->gen();
        $this->assertTrue(is_numeric($id),"id is not int: ".$id);
        $this->assertTrue(19===strlen($id),"id length no 19: ".$id);
    }

    function testGetDb()
    {
        $fake_db = __NAMESPACE__.'\FakeSSDB';
        $db = PMVC\plug($this->plug)->getDb('manager');
        $this->assertEquals($fake_db,get_class($db->db));
    }

    /**
     * find ./ -type f -print | xargs -I{} php -l {}
     */
    function testSyntaxError()
    {
        $files = glob(__DIR__.'/../src/dbs/*.php');
        foreach ($files as $f) {
            $r = exec('php -l '.$f);
            $this->assertStringStartsWith('No syntax errors',$r);
        }
    }
}




