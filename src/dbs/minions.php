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
       if ($md5Only) {
          return $urlMd5;
       } else {
          return $this->getUrlKeyByMd5($urlMd5);
       }
    }

    function getUrlKeyByMd5($md5)
    {
       $dbKey = sprintf($this->keys['url'], $md5);
       if (!isset($this[$dbKey])) {
            $this[$dbKey] = $url; 
       }
       return $dbKey;
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
