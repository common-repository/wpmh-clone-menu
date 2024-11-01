<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://valabhavesh.wordpress.com
 * @since             1.0.0
 * @package           Wpmh_Clone_Menu
 *
 * @wordpress-plugin
 * Plugin Name:       WPMH Clone Menu
 * Plugin URI:        https://valabhavesh.wordpress.com
 * Description:       This plugin is easy to use for copy the menus from simply the existing menu which you want to duplicate and enter a new name for copy menu. And quickly duplicate a menu in WordPress.
 * Version:           1.0.0
 * Author:            Vala Bhavesh V
 * Author URI:        https://valabhavesh.wordpress.com/about/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       wpmh-clone-menu
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
define( 'WPMH_CLONE_MENU_VERSION', '1.0.0' );

define( 'WPMH_CLONE_MENU_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPMH_CLONE_MENU_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpmh-clone-menu-activator.php
 */
function wpmh_clone_menu_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpmh-clone-menu-activator.php';
	Wpmh_Clone_Menu_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpmh-clone-menu-deactivator.php
 */
function wpmh_clone_menu_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpmh-clone-menu-deactivator.php';
	Wpmh_Clone_Menu_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'wpmh_clone_menu_activate' );
register_deactivation_hook( __FILE__, 'wpmh_clone_menu_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpmh-clone-menu.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpmh_clone_menu() {

	$plugin = new Wpmh_Clone_Menu();
	$plugin->run();

}
run_wpmh_clone_menu();