<?php
namespace IdOfThings;

use PHPUnit_Framework_TestCase;

class BigIntGuidTest extends PHPUnit_Framework_TestCase
{
    private $_plug = TestPlug;
    function testGenCallback()
    {
        $p = \PMVC\plug($this->_plug);
        $i = 0;
        $ids = [];
        $new = $p->gen(null, function ($new) use (&$i, &$ids) {
            $ids[]=$new;
            if (!$i) {
                $i++; 
                return true;
            } else {
                return false;
            }
        });
        $this->assertEquals(1, $i);
        $this->assertEquals(2, count($ids));
    }

    function testCallbackPassedByReference()
    {
        $p = \PMVC\plug($this->_plug);
        $expected = 'xxx';
        $actual = $p->gen(null, function ($new) use ($expected){
            $new = $expected;
            return false;
        });
        $this->assertNotEquals($expected, $actual);
        $actual = $p->gen(null, function (&$new) use ($expected){
            $new = $expected;
            return false;
        });
        $this->assertEquals($expected, $actual);
    }
}