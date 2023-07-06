<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://codereyes.com/
 * @since             1.0.0
 * @package           Ce_Trustpilot_Review
 *
 * @wordpress-plugin
 * Plugin Name:       CE TrustPilot Review
 * Plugin URI:        https://codereyes.com/ce-trustpilot-review
 * Description:       This 
 * Version:           1.0.0
 * Author:            Codereyes
 * Author URI:        https://codereyes.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ce-trustpilot-review
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CE_TRUSTPILOT_REVIEW_VERSION', '1.0.0' );

define( 'CE_TRUSTPILOT_REVIEW_TABLE', 'ce_trustpilot_reviews' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ce-trustpilot-review-activator.php
 */
function activate_ce_trustpilot_review() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ce-trustpilot-review-activator.php';
	 (new Ce_Trustpilot_Review_Activator)->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ce-trustpilot-review-deactivator.php
 */
function deactivate_ce_trustpilot_review() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ce-trustpilot-review-deactivator.php';
	 (new Ce_Trustpilot_Review_Deactivator)->deactivate();
}

register_activation_hook( __FILE__, 'activate_ce_trustpilot_review' );
register_deactivation_hook( __FILE__, 'deactivate_ce_trustpilot_review' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ce-trustpilot-review.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ce_trustpilot_review() {

	$plugin = new Ce_Trustpilot_Review();
	$plugin->run();

}
run_ce_trustpilot_review();
