<?php
namespace IdOfThings\dbs;

class OutSource extends \IdOfThings\BaseGuidDb 
{
    protected $groupKey='out_source_ids';

    private $dates;

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

    /**
     * add guess date
     */
    public function addGuessDate($guess_dates,$force=null)
    {
        $plugGuid = \PMVC\plug('guid'); 
        $db_images = $plugGuid->getDb('OutSource104Images');
        $db_dates = $plugGuid->getDb('OutSource104Dates');
        foreach ($guess_dates as $token=>$v) {
            $is_save = false;
            if ( !isset($db_dates[$v['date']])
                && !isset($db_images[$token])
               ) {
                $this->excuteSaveGuessDate($token,$v);
                $is_save = true;
            }
            if ($force && !$is_save) {
                $origin_date = \PMVC\fromJson($db_images[$token])->date;
                unset($db_dates[$origin_date]);
                $this->excuteSaveGuessDate($token,$v);
            }
        }
    }

    public function excuteSaveGuessDate($token, $v)
    {
        $plugGuid = \PMVC\plug('guid'); 
        $db_images = $plugGuid->getDb('OutSource104Images');
        $db_dates = $plugGuid->getDb('OutSource104Dates');
        $db_dates[$v['date']] = $token;    
        $db_images[$token] = json_encode($v);
    }

    /**
     * get 104 create_time
     */
     public function get104CreateTime($sign) 
     {
        if (substr($sign,0,4)>=2014) {
            return $sign;
        }
        if(empty($this->date[$sign])){
            $plugGuid = \PMVC\plug('guid'); 
            $db_images = $plugGuid->getDb('OutSource104Images');
            if(isset($db_images[$sign])){
                $this->date[$sign] = json_decode($db_images[$sign])->date;
            }else{
                $this->date[$sign] = '';
            }
        }
        return $this->date[$sign];
     }

}
