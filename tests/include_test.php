<?php
namespace IdOfThings;
include __DIR__ . '/../vendor/autoload.php';

\PMVC\Load::plug(['unit' => null], [__DIR__ . '/../../']);

\PMVC\l(__DIR__ . '/resources/FakeSSDB');
\PMVC\l(__DIR__ . '/resources/BaseDbTest');

const TestPlug = 'guid';
