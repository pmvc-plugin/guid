<?php

namespace IdOfThings\dbs;

use IdOfThings\BaseGuidDb;

/**
 * Key: Year_Month_Day_Hour_Site_GUID
 * Value: [
 *  server: [] 
 *  clinet: []
 *  params: [] 
 * ]
 */
class LucencyView  extends BaseGuidDb
{
    protected $groupKey='lucency_view';
}
