<?php
namespace IdOfThings\dbs;

class OutSource 
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function add104OutSource($case)
    {
        $site_id = $case->site_id;
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
        $case->guid = $guid;
        $json = json_encode($case); 
        $this->db->hset($db_case,$guid,$json);
        return $guid;
    }    

    public function all($data=array())
    {
        $db_case = $this->getOutSourceDb(); 
        if(empty($data)){
	    return $this->db->hgetall($db_case);
        }else{
	    return $this->db->multi_hget($db_case,$data);
        }
    }

    public function isOurSourceExists($key)
    {
        $db_case = $this->getOutSourceDb(); 
        return $this->db->hexists($db_case, $key);
    }

    
    private function get104Db()
    {
        return \PMVC\plug('guid')->getDbKey('out_source_104_ids');
    }

    private function get518Db()
    {
        return \PMVC\plug('guid')->getDbKey('out_source_518_ids');
    }

    private function getOutSourceDb()
    {
        return \PMVC\plug('guid')->getDbKey('out_source_ids');
    }

}
