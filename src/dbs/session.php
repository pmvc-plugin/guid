<?php
namespace IdOfThings\dbs;

class session extends \IdOfThings\BaseGuidDb
{
    protected $groupKey='session';
    public function __construct($db)
    {
        $this->groupDb = \PMVC\plug('guid')->getDb('GlobalKey')[$this->groupKey];
        $this->db = $db->getDb($this->groupDb, 'tmp');
    }
}
