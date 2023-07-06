<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://codereyes.com/
 * @since      1.0.0
 *
 * @package    Ce_Trustpilot_Review
 * @subpackage Ce_Trustpilot_Review/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ce_Trustpilot_Review
 * @subpackage Ce_Trustpilot_Review/includes
 * @author     Codereyes <codereyesit@gmail.com>
 */
class Ce_Trustpilot_Review_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ce-trustpilot-review',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
