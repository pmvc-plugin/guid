<?php
namespace IdOfThings\dbs;

class OutSource 
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public add104OurSource($case)
    {
        $site_id = $case['site_id']
        $db_104 = $this->get104Db();
        $db_case = $this->getOutSourceDb(); 
        $guid = $this->db->hget($db_104,$site_id);
        if (!$guid) {
            $generator = \PMVC\plug('guid');
            $guid = $generator->gen();
            while($this->isOurSourceExists($guid)){
                $guid = $generator->gen();
            }
            $this->db->hset($db_104,$site_id,$guid);
        }
        $case['guid'] = $guid;
        $json = json_encode($case); 
        $this->db->hset($db_case,$guid,$json);
        return $guid;
    }    

    public isOurSourceExists($key)
    {
        $db_case = $this->getOutSourceDb(); 
        return $this->db->hexists($db_case, $key);
    }

    
    private function get104Db()
    {
        return \PMVC\plug('guid')->getDbKey('out_source_104');
    }

    private function get518Db()
    {
        return \PMVC\plug('guid')->getDbKey('out_source_518');
    }

    private function getOutSourceDb()
    {
        return \PMVC\plug('guid')->getDbKey('out_source');
    }

}
