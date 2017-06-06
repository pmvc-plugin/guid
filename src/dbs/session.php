<?php
namespace IdOfThings\dbs;

class session extends \IdOfThings\BaseGuidTempDb
{
    protected $groupKey='session';

    public function __construct($db)
    {
        parent::__construct($db);
        if (\PMVC\exists('session', 'plugin')) {
            $this->setCache(
                \PMVC\plug('session')->getLifeTime()
            );
        }
    }
}
