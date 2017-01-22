<?php
/**
 * Elgg River Grouping plugin
 * @package river_grouping
 */

/**
 * Main activity stream list page
 */
$options = array(
    'distinct' => false
);

elgg_register_rss_link();

$page_type = preg_replace('[\W]', '', elgg_extract('page_type', $vars, 'all'));
$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));
if ($subtype) {
    $selector = "type=$type&subtype=$subtype";
} else {
    $selector = "type=$type";
}

if ($type != 'all') {
    $options['type'] = $type;
    if ($subtype) {
        $options['subtype'] = $subtype;
    }
}

// flag to enable grouping
$enable_grouping = true;

switch ($page_type) {
    case 'mine':
        $title = elgg_echo('river:mine');
        $page_filter = 'mine';
        $options['subject_guid'] = elgg_get_logged_in_user_guid();
        $enable_grouping = false;
        break;
    case 'owner':
        $subject_username = elgg_extract('subject_username', $vars, '');
        $subject = get_user_by_username($subject_username);
        if (!$subject) {
            register_error(elgg_echo('river:subject:invalid_subject'));
            forward('');
        }
        elgg_set_page_owner_guid($subject->guid);
        $title = elgg_echo('river:owner', array(htmlspecialchars($subject->name, ENT_QUOTES, 'UTF-8', false)));
        $page_filter = 'subject';
        $options['subject_guid'] = $subject->guid;
        $enable_grouping = false;
        break;
    case 'friends':
        if (!RiverGroupingOptions::isEnabledForFriends()) {
            $enable_grouping = false;
        }
        $title = elgg_echo('river:friends');
        $page_filter = 'friends';
        $options['relationship_guid'] = elgg_get_logged_in_user_guid();
        $options['relationship'] = 'friend';
        break;
    default:
        $title = elgg_echo('river:all');
        $page_filter = 'all';
        break;
}
    
// if admin, check option for admins from settings
if ($enable_grouping && elgg_is_admin_logged_in()) {
    if (!RiverGroupingOptions::isEnabledForAdmins()) {
        $enable_grouping = false;
    }
}

// start: code copied from elgg_list_river function
$defaults = array(
    'offset'     => (int) max(get_input('offset', 0), 0),
    'limit'      => (int) max(get_input('limit', max(20, elgg_get_config('default_limit'))), 0),
    'pagination' => true,
    'list_class' => 'elgg-list-river',
    'no_results' => '',
);

$options = array_merge($defaults, $options);

if ($enable_grouping) {
    // check if to apply on current page
    $enable_grouping = RiverGroupingOptions::applyRiverGroupingOnCurrentPage($options['offset']);
}
if ($enable_grouping) {
    $dbprefix = elgg_get_config('dbprefix');
    $options['wheres'] = array(" (rv.id in (SELECT MAX(id) FROM {$dbprefix}river GROUP BY subject_guid) ) ");
}

if (!$options["limit"] && !$options["offset"]) {
    // no need for pagination if listing is unlimited
    $options["pagination"] = false;
}

$options['count'] = true;
$count = elgg_get_river($options);

if ($count > 0) {
    $options['count'] = false;
    $items = elgg_get_river($options);
} else {
    $items = array();
}

$options['count'] = $count;
$options['items'] = $items;
// end: code copied from elgg_list_river function

if ($enable_grouping) {
    foreach ($items as $item) {
        $item->show_more = true;
    }
}

$activity = elgg_view('page/components/list', $options);

$content = elgg_view('core/river/filter', array('selector' => $selector));
$sidebar = elgg_view('core/river/sidebar');
$params = array(
    'title' => $title,
    'content' => $content . $activity,
    'sidebar' => $sidebar,
    'filter_context' => $page_filter,
    'class' => 'elgg-river-layout',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
