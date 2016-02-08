<?php
namespace IdOfThings\dbs;
class ForceRaw extends \IdOfThings\BaseGuidDb
{
    protected $groupKey='force_raw';

    function add($content)
    {
        $plugGuid = \PMVC\plug('guid'); 
        $self = $this;
        $guid = $plugGuid->gen(null, function($new) use ($self){
            return isset($self[$new]); 
        });
        $this[$guid] = json_encode($content); 
        return $guid;
    }
}
