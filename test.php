<?php
PMVC\Load::plug();
PMVC\addPlugInFolder('../');
class GuidTest extends PHPUnit_Framework_TestCase
{
    private $plug = 'guid';
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
        $fake_db = 'FakeSSDB';
        $db_plug = 'fake_ssdb'; 
        \PMVC\option('set','GUID_DB',$db_plug);
        \PMVC\unplug($this->plug);
        PMVC\plug($db_plug,array(
            _CLASS => $fake_db
        ));
        $db = PMVC\plug($this->plug)->getDb('manager');
        $this->assertEquals($fake_db,get_class($db->db));
    }
}

class FakeSSDB extends \PMVC\PlugIn
{
    function getdb(){return $this;}
}



