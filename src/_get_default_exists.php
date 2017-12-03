<?php
namespace IdOfThings;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\GetDefaultExists';

class GetDefaultExists
{
    public function __invoke($caller)
    {
       return new DefaultExists($caller);
    }
}

class DefaultExists
{
    private $_caller;

    public function __construct($caller)
    {
        $this->_caller = $caller; 
    }

    public function __invoke($newGuid)
    {
        return isset($this->_caller[$newGuid]);
    }
}
