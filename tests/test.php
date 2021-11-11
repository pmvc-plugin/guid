<?php

namespace IdOfThings;

use PMVC;

class GuidTest extends BaseModelTest
{
    private $plug = TestPlug;
    function testPlugin()
    {
        ob_start();
        print_r(PMVC\plug($this->plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->haveString($this->plug, $output);
    }

    function testGetModel()
    {
        $fakeModel = 'PMVC\HashMap';
        $model = PMVC\plug($this->plug)->getModel('GlobalKeyGuid');
        $this->assertEquals($fakeModel, get_class($model->getEngineModel()));
    }

    /**
     * find ./ -type f -print | xargs -I{} php -l {}
     */
    function testSyntaxError()
    {
        $files = glob(__DIR__ . '/../src/models/*.php');
        foreach ($files as $f) {
            $r = exec('php -l ' . $f);
            if (is_null($r)) {
                $r = 'No syntax errors';
            }
            $this->assertStringStartsWith('No syntax errors', (string) $r);
        }
    }
}
