<?php
/**
 * Elgg River Grouping plugin
 * @package river_grouping
 */

$language = array(

    'river_grouping' => 'River Grouping',
    'river_grouping:show_more_btn' => 'Show more from %s',
    'river_grouping:nomore' => 'No other activity from %s',
    
    // settings
    'river_grouping:settings:title' => 'Basic Configuration',
    'river_grouping:settings:enable_for_admin' => 'Enable for Administrators',
    'river_grouping:settings:enable_for_admin:help' => 'Check this if want to enable river grouping for site administrators',
    'river_grouping:settings:enable_for_friends' => 'Enable on Friends view',
    'river_grouping:settings:enable_for_friends:help' => 'Check this if want to enable river grouping on Friends view',
    'river_grouping:settings:enable_only_on_firstpage' => 'Enable only on 1st page of activity river',
    'river_grouping:settings:enable_only_on_firstpage:help' => 'Check this if want to enable river grouping only on 1st page of activity river. After 1st page all entries will be displayed as usual, no matter if will show some which have been included in "show more" boxes of 1st page',
    'river_grouping:settings:items_to_show' => 'Number of items to show',
    'river_grouping:settings:items_to_show:help' => 'Enter the number of grouped items to display',
    
);

add_translation('en', $language);
