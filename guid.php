<?php
namespace IdOfThings;

// \PMVC\l(__DIR__.'/xxx.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\guid';

class guid extends \PMVC\PlugIn
{
    public function init()
    {
        $guid = new BigIntGuid(); 
        $this->setDefaultAlias($guid);
    }
}
