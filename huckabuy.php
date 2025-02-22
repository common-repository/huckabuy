<?php

/**
 * Plugin Name:       Huckabuy
 * Plugin URI:        https://huckabuy.com/
 * Description:       Huckabuy’s Structured Data plugin helps search engines understand your content and improve your appearance in search results.
 * Version:           1.0.1
 * Author:            Huckabuy
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       huckabuy
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
define( 'HUCKABUY', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-huckabuy-activator.php
 */
function activate_huckabuy() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-huckabuy-activator.php';
	Huckabuy_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-huckabuy-deactivator.php
 */
function deactivate_huckabuy() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-huckabuy-deactivator.php';
	Huckabuy_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_huckabuy' );
register_deactivation_hook( __FILE__, 'deactivate_huckabuy' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-huckabuy.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_huckabuy() {

	$plugin = new Huckabuy();
	$plugin->run();

}
run_huckabuy();
