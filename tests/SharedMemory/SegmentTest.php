<?php

require_once('../../lib/SharedMemory/Segment.php');

class SegmentTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorBadparameters() {
        $shm = new Segment('a', 'a', 'a');
    }
    
    public function testAttributeAccessors() {
        $shm = new Segment('001');
        $shm->clear();
        
        $expected = true;
        $this->assertEquals($expected, $shm->set('123', 'foo'));
        
        $expected = 'foo';
        $this->assertEquals($expected, $shm->get('123'));
        
    }
    
    public function testAttributeExists() {
        $shm = new Segment('001');
        $shm->clear();
        
        $expected = false;
        $this->assertEquals($expected, $shm->exists('123'));
        

        $shm->set('123', 'foo');
        $expected = true;
        $this->assertEquals($expected, $shm->exists('123'));
    }
    
    public function testAttributeDel() {
        $shm = new Segment('001');
        $shm->clear();
        
        $shm->set('123', 'foo');
        
        $expected = true;
        $this->assertEquals($expected, $shm->del('123'));

        $expected = false;
        $this->assertEquals($expected, $shm->exists('123'));
    }
    
    public function _testRemove() {
        $shm = new Segment('002');
        $shm->clear();
        $shm->set('123', 'foo');
        
        $expected = true;
        $this->assertEquals($expected, $shm->remove());
        
        $shm2 = new Segment('002');
        $expected = false;
        $this->assertEquals($expected, $shm->exists('123'));
    }
    
}
?>
