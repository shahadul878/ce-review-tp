<?php

/**
 * Fired during plugin activation
 *
 * @link       https://codereyes.com/
 * @since      1.0.0
 *
 * @package    Ce_Trustpilot_Review
 * @subpackage Ce_Trustpilot_Review/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ce_Trustpilot_Review
 * @subpackage Ce_Trustpilot_Review/includes
 * @author     Codereyes <codereyesit@gmail.com>
 */
class Ce_Trustpilot_Review_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {
		// Create the custom database table
		$this->create_database_table();
	}

	private function create_database_table() {
		// Create the custom database table
		global $wpdb;
		$table_name      = $wpdb->prefix . CE_TRUSTPILOT_REVIEW_TABLE;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        review_title varchar(255) NOT NULL,
        review_content text NOT NULL,
        reviewer_name varchar(255) NOT NULL,
        reviewer_location varchar(255) NOT NULL,
        review_date datetime NOT NULL,
        review_rating varchar(25) NOT NULL,
        review_rating_img_url varchar(255) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}
