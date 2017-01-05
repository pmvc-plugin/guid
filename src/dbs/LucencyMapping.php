<?php

namespace IdOfThings\dbs;

use IdOfThings\BaseGuidDb;

/**
 * Key: pageview_id 
 * Value: [
 *  view: lucency_view_guid
 *  action: [
 *    ...actions_guid
 *  ]
 * ]
 */
class LucencyMapping extends BaseGuidDb
{
    protected $groupKey='lucency_mapping';
}
