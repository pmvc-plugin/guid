<?php
PMVC\Load::plug();
PMVC\setPlugInFolder('../');
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

}
