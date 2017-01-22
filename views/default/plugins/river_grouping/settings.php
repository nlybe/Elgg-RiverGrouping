<?php
/**
 * Elgg River Grouping plugin
 * @package river_grouping
 */

$plugin = elgg_get_plugin_from_id('river_grouping');

$basic_settings .= elgg_format_element('div', [], elgg_view_input('checkbox', array(
    'id' => 'enable_for_admin',
    'name' => 'params[enable_for_admin]',
    'label' => elgg_echo('river_grouping:settings:enable_for_admin'),
    'checked' => ($plugin->enable_for_admin || !isset($plugin->enable_for_admin) ? true : false),
    'help' => elgg_echo('river_grouping:settings:enable_for_admin:help'),
)));

$basic_settings .= elgg_format_element('div', [], elgg_view_input('checkbox', array(
    'id' => 'enable_for_friends',
    'name' => 'params[enable_for_friends]',
    'label' => elgg_echo('river_grouping:settings:enable_for_friends'),
    'checked' => ($plugin->enable_for_friends || !isset($plugin->enable_for_friends) ? true : false),
    'help' => elgg_echo('river_grouping:settings:enable_for_friends:help'),
)));

$basic_settings .= elgg_format_element('div', [], elgg_view_input('checkbox', array(
    'id' => 'enable_only_on_firstpage',
    'name' => 'params[enable_only_on_firstpage]',
    'label' => elgg_echo('river_grouping:settings:enable_only_on_firstpage'),
    'checked' => ($plugin->enable_only_on_firstpage || !isset($plugin->enable_only_on_firstpage) ? true : false),
    'help' => elgg_echo('river_grouping:settings:enable_only_on_firstpage:help'),
)));

$items_to_show = $plugin->items_to_show;
$basic_settings .= elgg_format_element('div', [], elgg_view_input('text', array(
    'id' => 'items_to_show',
    'name' => 'params[items_to_show]',
    'label' => elgg_echo('river_grouping:settings:items_to_show'),
    'value' => (is_numeric($items_to_show) && $items_to_show>0?$plugin->items_to_show:RiverGroupingOptions::RG_DEFAULT_ITEMS_NO),
    'help' => elgg_echo('river_grouping:settings:items_to_show:help'),
    'style' => 'width: 60px;',
)));

$title = elgg_format_element('h3', [], elgg_echo('river_grouping:settings:title'));
echo elgg_view_module('inline', '', $basic_settings, ['header' => $title]);
