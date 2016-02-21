<?php
namespace IdOfThings\dbs;
class minions extends \IdOfThings\BaseGuidDb
{
    protected $groupKey='minions';


    function getDate()
    {
        return date('Ymd');
    }

    function addRaw($content, $key)
    {
        $this[$key] = json_encode($content);
    }
}
