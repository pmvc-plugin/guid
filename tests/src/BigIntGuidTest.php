<?php

namespace IdOfThings;

use PMVC\TestCase;

class BigIntGuidTest extends TestCase
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

    function testGenId()
    {
        $id = \PMVC\plug($this->_plug)->gen();
        $this->assertTrue(is_numeric($id),"id is not int: ".$id);
        $this->assertTrue(19===strlen($id),"id length no 19: ".$id);
    }

    function testVerify()
    {
        $timestamp = gmmktime(1, 2, 3, 4, 5, 2021);
        $p = \PMVC\plug($this->_plug);
        $id = $p->gen(null, null, $timestamp);
        $actual = $p->verify($id);
        $this->assertEquals('20210405010203', $actual);
    }

    function testVerifyWithEdgeDate()
    {
        $timestamp = gmmktime(1, 2, 3, 3, 31, 2021);
        $p = \PMVC\plug($this->_plug);
        $id = $p->gen(null, null, $timestamp);
        $actual = $p->verify($id);
        $this->assertEquals('20210331010203', $actual);
    }

    function testOldKey()
    {
        $id = '1000455392031058124';
        $p = \PMVC\plug($this->_plug);
        $actual = $p->verify($id);
        $this->assertEquals('20210405010203', $actual);
    }
}
