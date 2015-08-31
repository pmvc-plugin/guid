<?php
namespace IdOfThings\dbs;

class session extends \IdOfThings\BaseGuidDb
              implements \SessionHandlerInterface
{
    protected $groupKey='session';

    public function __construct($db)
    {
        parent::__construct($db);
        session_set_save_handler($this, true);
        session_start();
    }
    

    public function open( $save_path , $session_name )
    {
    }

    public function close()
    {
    }

    public function read( $session_id )
    {
        return $this[$session_id];
    }

    public function write($session_id , $session_data )
    {
        $this[$session_id] = $session_data;
    }

    public function destroy( $session_id )
    {
        unset($this[$session_id]);
    }

    public function gc( $maxlifetime )
    {
        return true;
    }
}
