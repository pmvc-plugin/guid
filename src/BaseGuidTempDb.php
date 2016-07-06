<?php
namespace IdOfThings;

class BaseGuidTempDb implements BaseGuidDb
{
    public function __construct($db)
    {
        $this->groupDb = \PMVC\plug('guid')
             ->getDb('GlobalKey')[$this->groupKey];
        $this->db = $db->getDb($this->groupDb, 'tmp');
    }
}
