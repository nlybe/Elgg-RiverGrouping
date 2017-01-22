<?php
/**
 * Elgg River Grouping plugin
 * @package river_grouping
 * *************************
 * 
 * Primary river item view
 *
 * Calls the individual view saved for that river item. Most of these
 * individual river views then use the views in river/elements.
 *
 * @uses $vars['item'] ElggRiverItem
 */

elgg_require_js('river_grouping/river_item_more');

// @todo remove this in Elgg 1.9
global $_elgg_special_river_catch;
if (!isset($_elgg_special_river_catch)) {
	$_elgg_special_river_catch = false;
}
if ($_elgg_special_river_catch) {
	// we changed the views a little in 1.8.1 so this catches the plugins that
	// were updated in 1.8.0 and redirects to the layout view
	echo elgg_view('river/elements/layout', $vars);
	return true;
}
$_elgg_special_river_catch = true;

$item = $vars['item'];
/* @var ElggRiverItem $item */

echo elgg_view($item->getView(), $vars);
if (isset($item->show_more)) {
    // check if this user has more river items
    $options = array(
        'distinct' => false,
        'subject_guid' => $item->subject_guid,
        'limit' => 0,
        'count' => true,
    );
    $count = elgg_get_river($options);

    // the condition should be more than 1 since we have already shown the 1st one
    if ($count>1) {
        $user = get_user($item->subject_guid);
        $show_more_btn = elgg_view('output/url', array(
            'id' => "river_more_btn_{$item->subject_guid}",
            'href' => "#",
            'text' => elgg_echo('river_grouping:show_more_btn', array($user->name)).elgg_format_element('span', ['class' => "river_btn_down"], ''),
            'class' => "river_more_link elgg-button-action",      
        ));
        //$show_more_block = elgg_view('river_grouping/river_item_more', array('subject_guid' => $item->subject_guid));
        $item_id = elgg_format_element('span', ['class' => "item_id"], $item->subject_guid);
        $river_more_block =  elgg_format_element('div', ['id' => "river_more_block_{$item->subject_guid}", 'class' => "river_more_block"], '');
        echo elgg_format_element('div', ['class' => "river_more_box"], $item_id.$show_more_btn.$river_more_block);
    }
}

$_elgg_special_river_catch = false;
