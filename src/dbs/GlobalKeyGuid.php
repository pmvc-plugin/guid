<?php

namespace IdOfThings\dbs;

use IdOfThings\BaseGuidDb;

/**
 * format: key->guid
 */
class GlobalKeyGuid extends BaseGuidDb
{
    protected $groupTable='key_guid';
}
