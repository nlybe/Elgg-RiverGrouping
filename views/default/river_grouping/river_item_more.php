<?php
/**
 * Elgg River Grouping plugin
 * @package river_grouping
 */

//$subject_guid = $vars['subject_guid'];
$subject_guid = get_input('subject_guid');
$user = get_user($subject_guid);

$options = array(
    'distinct' => false
);

$options['type'] = $type;
$options['subtype'] = $subtype;
$options['subject_guid'] = $subject_guid;
$options['limit'] = RiverGroupingOptions::getNoOfItems()+1;
$options['pagination'] = false;

$options['count'] = true;
$count = elgg_get_river($options);

if ($count > 0) {
    if ($count == 1) {
        $items = array();
        echo elgg_echo('river_grouping:nomore', array($user->name));
    }
    else {
        $options['count'] = false;
        $items = elgg_get_river($options);

        // remove 1st element which normally exists already in river
        unset($items[0]);

        $options['count'] = $count;
        $options['items'] = $items;

        echo elgg_view('page/components/list', $options);    
    }
} 



