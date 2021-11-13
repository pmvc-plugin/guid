<?php

namespace IdOfThings;

abstract class PrivateModel extends GetModel
{
    public function init()
    {
        $this->setConnected(true);
    }

    public function getBaseModel()
    {
        return 'IdOfThings\BaseGuidModel';
    }

    public function getEngine()
    {
        return \PMVC\plug('guid')->getStorage();
    }

    public function getFailback($id)
    {
        return false;
    }
}
