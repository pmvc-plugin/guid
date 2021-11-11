<?php

namespace IdOfThings\models;

use IdOfThings\BaseGuidModel;

/**
 * Key: pageview_id 
 * Value: [
 *  view: [
 *      ...lucency_view_guid
 *  ],
 *  action: [
 *    ...actions_guid
 *  ]
 * ]
 */
class LucencyMapping extends BaseGuidModel
{
    protected $modelKey='lucency_mapping';
}
