<?php
namespace IdOfThings\models;
class minions extends \IdOfThings\BaseGuidModel
{
    protected $modelKey='minions';


    function getDate()
    {
        return date('Ymd');
    }

    function addRaw($content, $key)
    {
        $this[$key] = json_encode($content);
    }
}
