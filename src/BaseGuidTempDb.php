<?php
namespace IdOfThings;

class BaseGuidTempDb extends BaseGuidDb
{
    public function __construct($db)
    {
        if(!empty($this->groupKey)){
            $this->groupTable = \PMVC\plug('guid')->
                manager()->
                getGuid($this->groupKey);
        }
        $this->db = $db->getDb($this->groupTable, 'tmp');
    }
}
