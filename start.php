<?php
/**
 * Elgg River Grouping plugin
 * @package river_grouping
 */
 
require_once(dirname(__FILE__) . '/lib/hooks.php');

elgg_register_event_handler('init', 'system', 'river_grouping_init');
 
/**
 * river_grouping plugin initialization functions.
 */
function river_grouping_init() {
 	
    // register a library of helper functions
    elgg_register_library('elgg:river_grouping', elgg_get_plugins_path() . 'river_grouping/lib/river_grouping.php');
    
    // register extra css
    elgg_extend_view('elgg.css', 'river_grouping/river_grouping.css');
    
    // replace river page handler
    elgg_unregister_page_handler('activity', '_elgg_river_page_handler');
    elgg_register_page_handler('activity', 'river_grouping_river_page_handler');   
    
    // register ajax views
    elgg_register_ajax_view('river_grouping/river_item_more');    
    
    // add access check back into the river queries: OBS
    // elgg_register_plugin_hook_handler('get_sql', 'access', 'river_grouping_access_query');    
    
}

/**
 * New river page handler: replace the core river
 * 
 * @param type $page
 * @return boolean
 */
function river_grouping_river_page_handler($page) {
    elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

    // make a URL segment available in page handler script
    $page_type = elgg_extract(0, $page, 'all');
    $page_type = preg_replace('[\W]', '', $page_type);

    if ($page_type == 'owner') {
        elgg_gatekeeper();
        $page_username = elgg_extract(1, $page, '');
        if ($page_username == elgg_get_logged_in_user_entity()->username) {
            $page_type = 'mine';
        } else {
            $vars['subject_username'] = $page_username;
        }
    }

    $vars['page_type'] = $page_type;

    echo elgg_view_resource("river_grouping/river", $vars);
    return true;
}


?>
