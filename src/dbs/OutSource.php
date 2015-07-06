<?php
namespace IdOfThings\dbs;

class OutSource extends \IdOfThings\BaseDb 
{
    protected $default_key='out_source_ids';

    public function add104OutSource($case)
    {
        $plugGuid = \PMVC\plug('guid'); 
        $db_104 = $plugGuid->getDb('OutSource104');
        return $this->addDifferentSourceBySite($case,$db_104);
    }

    public function add518OutSource($case)
    {
        $plugGuid = \PMVC\plug('guid'); 
        $db_518 = $plugGuid->getDb('OutSource518');
        return $this->addDifferentSourceBySite($case,$db_518);
    } 

    public function addDifferentSourceBySite($case,$db_site)
    {
        $plugGuid = \PMVC\plug('guid'); 
        $site_id = $case->site_id;
        $db_case = $this; 
        $guid = $db_site[$site_id];
        if (!$guid) {
            $guid = $plugGuid->gen();
            while(isset($db_case[$guid])){
                $guid = $plugGuid->gen();
            }
            $db_site[$site_id] = $guid;
        }
        $case->guid = $guid;
        $json = json_encode($case); 
        $db_case[$guid] = $json;
        return $guid;
    }


}
