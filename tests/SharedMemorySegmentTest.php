<?php

require_once('../library/SharedMemorySegment.php');

class SharedMemorySegmentTest extends PHPUnit_Framework_TestCase {
    
    /**
     * @expectedException Exception
     */
    public function testConstructorBadparameters() {
        $shm = new SharedMemorySegment('a');
    }
    
    public function testAttributeAccessors() {
        $shm = new SharedMemorySegment('001');
        $shm->clear();
        
        $expected = true;
        $this->assertEquals($expected, $shm->set('123', 'foo'));
        
        $expected = 'foo';
        $this->assertEquals($expected, $shm->get('123'));
        
    }
    
    public function testAttributeExists() {
        $shm = new SharedMemorySegment('001');
        $shm->clear();
        
        $expected = false;
        $this->assertEquals($expected, $shm->exists('123'));
        

        $shm->set('123', 'foo');
        $expected = true;
        $this->assertEquals($expected, $shm->exists('123'));
    }
    
    public function testAttributeDel() {
        $shm = new SharedMemorySegment('001');
        $shm->clear();
        
        $shm->set('123', 'foo');
        
        $expected = true;
        $this->assertEquals($expected, $shm->del('123'));

        $expected = false;
        $this->assertEquals($expected, $shm->exists('123'));
    }
    
    public function _testRemove() {
        $shm = new SharedMemorySegment('002'); 
        $shm->clear();
        $shm->set('123', 'foo');
        
        $expected = true;
        $this->assertEquals($expected, $shm->remove());
        
        $shm2 = new SharedMemorySegment('002'); 
        $expected = false;
        $this->assertEquals($expected, $shm->exists('123'));
    }
    
}
?>
