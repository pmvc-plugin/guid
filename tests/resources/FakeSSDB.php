<?php
namespace IdOfThings;
use PMVC;
class FakeSSDB extends \PMVC\PlugIn
{
    function getdb(){return $this;}
}
