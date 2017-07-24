<?php

namespace IdOfThings\dbs;

use IdOfThings\BaseGuidDb;

/**
 * format: guid->key
 */
class GlobalGuidKey extends BaseGuidDb
{
    protected $groupTable='guid_key';
}
