<?php
namespace IdOfThings\dbs;
class minions extends \IdOfThings\BaseGuidDb
{
    protected $groupKey='minions';

    private $keys = array(
        'list'=>'list_%s_%s',
        'item'=>'item_%s_%s',
        'url'=>'data_url_%s'
    );

    function getUrlKey($url, $md5Only=false)
    {
       $urlMd5 = md5($url); 
       $dbKey = sprintf($this->keys['url'], $urlMd5);
       $guidPlug = \PMVC\plug('guid');
       if (!isset($this[$dbKey])) {
            $this[$dbKey] = $url; 
       }
       if ($md5Only) {
          return $urlMd5;
       } else {
          return $dbKey;
       }
    }

    function getListKey($date, $urlMd5)
    {
       $dbKey = sprintf($this->keys['list'], $date, $urlMd5);
       return $dbKey;
    }

    function getItemKey($date, $urlMd5)
    {
       $dbKey = sprintf($this->keys['item'], $date, $urlMd5);
       return $dbKey;
    }

    function getDate()
    {
        return date('Ymd');
    }

    function addRaw($content, $key)
    {
        $this[$key] = json_encode($content);
    }
}
