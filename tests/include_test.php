<?php
namespace IdOfThings;
include __DIR__.'/../vendor/autoload.php';
\PMVC\Load::plug();
\PMVC\addPlugInFolders([__DIR__.'/../../']);
include(__DIR__.'/resources/FakeSSDB.php');
include(__DIR__.'/resources/BaseDbTest.php');

const TestPlug = 'guid';
