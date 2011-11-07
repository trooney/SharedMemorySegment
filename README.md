SharedMemorySegment
-------------------

Simple object wrapper for PHP's shared memory segment implementation.


```php
$shm = new SharedMemorySegment('002');  // Create instance
$shm->set('123', 'foo');                // Save something
$shm->get('123');                       // Retrieve something
$shm->clear();                          // Clear segment 
$shm->detach();                         // Detach segment
````