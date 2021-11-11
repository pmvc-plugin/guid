<?php
namespace IdOfThings;

class BaseGuidTempModel extends BaseModel
{
    public function __construct($engine)
    {
        parent::__construct($engine);
        $this->engineModel = $engine->getModel($this->modelTable, 'tmp');
        if (empty($this->engineModel)) {
            return !trigger_error('Init engine model failed.');
        }
    }

    public function setTTL($num)
    {
        return $this->engineModel->setTTL($num);
    }
}
