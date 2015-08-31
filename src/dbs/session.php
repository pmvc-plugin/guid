<?php
namespace IdOfThings\dbs;

class session extends \IdOfThings\BaseGuidDb
              implements \SessionHandlerInterface
{
    protected $groupKey='session';
    private $_storage=null;

    public function __construct($db)
    {
        parent::__construct($db);
        session_set_save_handler($this, true);
        session_start();
    }
    
    public function getStorage()
    {
        return $this->_storage;
    }

    public function open( $save_path , $session_name )
    {
        if (!$this->_storage) {
            $this->_storage = \PMVC\plug('guid')->getDb('session');
        }
    }

    public function close()
    {
    }

    public function read( $session_id )
    {
        \PMVC\log($this->_storage);
        return $this->_storage[$session_id];
    }

    public function write($session_id , $session_data )
    {
        \PMVC\log($session_id , $session_data);
        $this->_storage[$session_id] = $session_data;
    }

    public function destroy( $session_id )
    {

    }

    public function gc( $maxlifetime )
    {
        return true;
    }
}
