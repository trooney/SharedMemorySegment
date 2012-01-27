<?php
/**
 * Simple wrapper for shared memory segments
 * 
 * <code>
 * $shm = new SharedMemorySegment('002');  // Create instance
 * $shm->set('123', 'foo');                // Save something
 * $shm->get('123');                       // Retrieve something
 * $shm->clear();                          // Clear segment 
 * $shm->detach();                         // Detach segment
 * </code> 
 * 
 * @author Tyler Rooney <tyler@tylerrooney.ca
 * @copyright 2012 Tyler Rooney
 */
class SharedMemorySegment {
    
    /**
     * Octal permissions for segment
     * @var int
     */
    private $_permissions = null;
    
    /**
     * sysvshm resource identifier
     * @var resource
     */
    private $_segment = null;
    
    /**
     * Functionality test (shm_has_var only on PHP >= 5.3)
     * @var boolean
     */
    static $_SHM_HAS_VAR_FUNC_AVAILABLE = null;
    
    /**
     * Identifier for segment
     * @var integer 
     */
    private $_shmKey = null;
    
    /**
     * Memory size in kbits for segment
     * @var integer
     */
    private $_memorySize = null;
    
    /**
     * Constructor
     * @throw exception 
     * @param integer $key
     * @param integer $memorySize
     * @param integer $permissions 
     */
    public function __construct($shmKey, $memorySize = 2048, $permissions = 0666) {
        
        foreach (compact('shmKey', 'memorySize', 'permissions') as $param => $value) {
            if (!is_numeric($value)) {
                throw new \InvalidArgumentException("SharedMemorySegment::__construct() expects {$param} to be an interger");
            }
        }
        
        $this->_shmKey = $shmKey;
        $this->_memorySize = $memorySize;
        $this->_permissions = $permissions;
        
        if (is_null(SharedMemorySegment::$_SHM_HAS_VAR_FUNC_AVAILABLE)) {
            if (function_exists('shm_has_var')) {
                SharedMemorySegment::$_SHM_HAS_VAR_FUNC_AVAILABLE = true;
            } else {
                SharedMemorySegment::$_SHM_HAS_VAR_FUNC_AVAILABLE = false;
            }
        }
            
    }
    
    /**
     * @param integer $key
     * @return boolean success
     */
    public function del($key) {
        return shm_remove_var($this->segment(), $key);
    }
    
    /**
     * @return boolean
     */
    public function detach() {
        return shm_detach($this->segment());
    }
    
    /**
     *
     * @see SharedMemorySegment::$_SHM_HAS_VAR_FUNC_AVAILABLE
     * @param type $key
     * @return type 
     */
    public function exists($key) {
        if (SharedMemorySegment::$_SHM_HAS_VAR_FUNC_AVAILABLE) {
            return shm_has_var($this->segment(), $key);
        } else {
            return (@shm_get_var($this->segment(), $key) !== FALSE);
        }
    }
    
    /**
     *
     * @param integer $key
     * @return boolean
     */
    public function get($key) {
        return shm_get_var($this->segment(), $key);
    }
    
    /**
     * Lazy-load sysvshm resource specified by $this->_shmKey
     * @return resource 
     */
    private function segment() {
        if (!$this->_segment) {
	    $this->_segment = shm_attach($this->_shmKey, $this->_memorySize, 0666);
        }
        return $this->_segment;
    }
    
    /**
     *
     * @param integer $key
     * @param mixed $val
     * @return boolean
     */
    public function set($key, $val) {
        return shm_put_var($this->segment(), $key, $val);
    }
    
    /**
     *
     * @return boolean
     */
    public function remove() {
        return shm_remove($this->segment());
    }
    
    /**
     * Alias for remove()
     * @return boolean
     */
    public function clear() {
        return $this->remove();
    }
    
}
