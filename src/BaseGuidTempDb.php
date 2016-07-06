<?php
namespace IdOfThings;

class BaseGuidTempDb extends BaseGuidDb
{
    public function __construct($db)
    {
        $this->groupDb = \PMVC\plug('guid')
             ->getDb('GlobalKey')[$this->groupKey];
        $this->db = $db->getDb($this->groupDb, 'tmp');
    }
}
