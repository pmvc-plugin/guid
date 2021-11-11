<?php

namespace IdOfThings\models;

use IdOfThings\BaseGuidTempModel;

class session extends BaseGuidTempModel
{
    protected $modelKey='session';

    public function __construct($engine)
    {
        parent::__construct($engine);
        if (\PMVC\exists('session', 'plugin')) {
            $this->setTTL(
                \PMVC\plug('session')->getLifeTime()
            );
        }
    }
}
