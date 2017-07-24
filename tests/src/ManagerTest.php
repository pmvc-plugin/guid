<?php

namespace IdOfThings;

class ManagerTest extends BaseDbTest 
{
    private $_plugin = TestPlug;

    private $_manager;

    function setup()
    {
        parent::setup();
        $this->_manager = \PMVC\plug($this->_plugin)->
            manager();
    }

    function testAddNewKey()
    {
        $key = 'test';
        $guid = $this->_manager->addNewKey($key);
        $this->assertEquals(
            $key,
            $this->_manager->getKey($guid)
        );
        $this->assertEquals(
            $guid,
            $this->_manager->getGuid($key)
        );
    }

    function testAddNewKeyWithHasGuid()
    {
        $mock = $this->getMockBuilder('\IdOfThings\manager')
            ->setMethods(['hasGuid'])
            ->getMock();
        $mock->expects($this->exactly(2))
            ->method('hasGuid')
            ->will($this->onConsecutiveCalls(true, false));
        $mock->caller = \PMVC\plug($this->_plugin);
        $mock->addNewKey('test');
    }

    function testRemove()
    {
        $key = 'test';
        $guid = $this->_manager->addNewKey($key);
        $this->assertTrue($this->_manager->hasKey($key));
        $this->assertTrue($this->_manager->hasGuid($guid));
        $this->_manager->remove($guid);
        $this->assertFalse($this->_manager->hasKey($key));
        $this->assertFalse($this->_manager->hasGuid($guid));
    }

    function testChangeKey()
    {
        $key = 'test';
        $newKey = 'test1';
        $guid = $this->_manager->addNewKey($key);
        $this->assertTrue($this->_manager->hasKey($key));
        $this->assertTrue($this->_manager->hasGuid($guid));
        $this->_manager->changeKey($guid, $newKey);
        $this->assertFalse($this->_manager->hasKey($key));
        $this->assertTrue($this->_manager->hasGuid($guid));
        $this->assertTrue($this->_manager->hasKey($newKey));
    }
}
