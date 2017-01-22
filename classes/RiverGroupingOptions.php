<?php
/**
 * Elgg River Grouping plugin
 * @package river_grouping
 */

class RiverGroupingOptions {

    const RG_ID = 'river_grouping';    // current plugin ID
    const RG_DEFAULT_ITEMS_NO = 5;    // Default number of grouped items to displa
    
    /**
     * Check if river grouping is enabled for site administrators
     * 
     * @return boolean
     */
    Public Static function isEnabledForAdmins() {
        $setting = elgg_get_plugin_setting('enable_for_admin', self::RG_ID);
        
        if ($setting === 'on') {
            return true;
        }

        return false;
    }
    
    /**
     * Check if river grouping is enabled on Friends view'
     * 
     * @return boolean
     */
    Public Static function isEnabledForFriends() {
        $setting = elgg_get_plugin_setting('enable_for_friends', self::RG_ID);
        
        if ($setting === 'on') {
            return true;
        }

        return false;
    }
    
    /**
     * Check if river grouping is enabled only on first page of activity river'
     * 
     * @return boolean
     */
    Public Static function isEnabledOnOnlyFirstPage() {
        $setting = elgg_get_plugin_setting('enable_only_on_firstpage', self::RG_ID);
        
        if ($setting === 'on') {
            return true;
        }

        return false;
    }    
    
    /**
     * According the enable_only_on_firstpage setting and and the $offset parameter check if should apply the 
     * river grouping on current page
     * 
     * @param type $offset
     * @return boolean
     */
    Public Static function applyRiverGroupingOnCurrentPage($offset = 0) {
        if (self::isEnabledOnOnlyFirstPage() && $offset > 0) {
            return false;
        }
        
        // default behavour
        return true;
    }     

    Public Static function getNoOfItems() {
        $items_to_show = elgg_get_plugin_setting('items_to_show', self::RG_ID);
        
        if (is_numeric($items_to_show) && $items_to_show>0) {
            return $items_to_show;
        }

        return self::RG_DEFAULT_ITEMS_NO;
    }    
         
}
