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

    function testGetDb()
    {
        $fake_db = 'PMVC\HashMap';
        $db = PMVC\plug($this->plug)->getDb('GlobalKeyGuid');
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
            if (is_null($r)) {
                $r = 'No syntax errors';
            }
            $this->assertStringStartsWith('No syntax errors', (string)$r);
        }
    }
}




