<?php
/**
 * Elgg River Grouping plugin
 * @package river_grouping
 *
 * All hooks are here
 */
 
/**
 * Add a custom access clause for river queries. Not used at the moment.
 *  
 * @param type $hook
 * @param type $type
 * @param array $return
 * @param type $params
 * @return type
 */
function river_grouping_access_query($hook, $type, $return, $params) {

    // anything else we can use to isolate river queries?
    // currently 'oe' is only used in core by river queries
    if ($params['table_alias'] != 'oe') {
        return $return;
    }
       
    if ($params['ignore_access']) {
        // return $return;
    }

    if (elgg_is_admin_logged_in()) {
        // return $return;
    }
    
    // skip this when viewing owner activity (mine or other users)
    // tt works by checking the current URL assuming that it looks like www.domain.com/activity/owner/username
    // may be should find a smarter way to do it
    $current_url = $_SERVER['REQUEST_URI'];
    $current_url_arr = explode('/', $current_url);
    $user = get_user_by_username(end($current_url_arr));
    if (
            $user instanceof \ElggUser && 
            $current_url_arr[count($current_url_arr)-2] == 'owner' && 
            $current_url_arr[count($current_url_arr)-3] == 'activity'
        ) {
        return $return;
    }
    
    $dbprefix = elgg_get_config('dbprefix');
    $return['ands'][] = "(rv.id in (SELECT MAX(id) FROM {$dbprefix}river GROUP BY subject_guid) )";
    
    return $return;
}
