<?php
namespace IdOfThings;

class BaseGuidTempDb extends BaseDb
{
    public function __construct($db)
    {
        parent::__construct($db);
        $this->db = $db->getDb($this->groupTable, 'tmp');
        if (empty($this->db)) {
            return !trigger_error('Init guid db failed.');
        }
    }
}
