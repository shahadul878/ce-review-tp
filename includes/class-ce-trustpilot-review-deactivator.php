<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://codereyes.com/
 * @since      1.0.0
 *
 * @package    Ce_Trustpilot_Review
 * @subpackage Ce_Trustpilot_Review/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Ce_Trustpilot_Review
 * @subpackage Ce_Trustpilot_Review/includes
 * @author     Codereyes <codereyesit@gmail.com>
 */
class Ce_Trustpilot_Review_Deactivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public function deactivate()
    {
        $this->drop_database();
    }

    private function drop_database()
    {
        // Delete the custom database table
        global $wpdb;
        $table_name = $wpdb->prefix . CE_TRUSTPILOT_REVIEW_TABLE;
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

}
