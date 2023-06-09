<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://webtechsofts.co.uk/
 * @since             1.0.0
 * @package           Trackbox_Push
 *
 * @wordpress-plugin
 * Plugin Name:       Trackbox Push
 * Plugin URI:        https://https://prosnicons.com/
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Web Tech Softs
 * Author URI:        https://https://webtechsofts.co.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       trackbox-push
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
define( 'TRACKBOX_PUSH_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-trackbox-push-activator.php
 */
function activate_trackbox_push() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-trackbox-push-activator.php';
	Trackbox_Push_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-trackbox-push-deactivator.php
 */
function deactivate_trackbox_push() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-trackbox-push-deactivator.php';
	Trackbox_Push_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_trackbox_push' );
register_deactivation_hook( __FILE__, 'deactivate_trackbox_push' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-trackbox-push.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_trackbox_push() {

	$plugin = new Trackbox_Push();
	$plugin->run();

}
run_trackbox_push();
