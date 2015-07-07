<?php
namespace IdOfThings\dbs;

class OutSource extends \IdOfThings\BaseDb 
{
    protected $default_key='out_source_ids';

    /**
     * db_name
     * 104 OutSource104
     * 518 OutSource518
     */
    public function addOutSource($case,$db_name)
    {
        $plugGuid = \PMVC\plug('guid'); 
        $site_id = $case->site_id;
        $db_site = $plugGuid->getDb($db_name);
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
