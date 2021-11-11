<?php
namespace IdOfThings;

class BaseGuidModel extends BaseModel 
{
    public function __construct($engine)
    {
        parent::__construct($engine);
        $this->engineModel = $engine->getModel($this->modelTable, $this->modelKey);
        if (empty($this->engineModel)) {
            return !trigger_error('Init engine model failed.');
        }
    }
}
