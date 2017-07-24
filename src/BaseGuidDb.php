<?php
namespace IdOfThings;

class BaseGuidDb extends BaseDb 
{
    public function __construct($db)
    {
        parent::__construct($db);
        $this->db = $db->getDb($this->groupTable, $this->groupKey);
        if (empty($this->db)) {
            return !trigger_error('Init guid db failed.');
        }
    }
}
