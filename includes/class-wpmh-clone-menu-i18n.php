<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://valabhavesh.wordpress.com
 * @since      1.0.0
 *
 * @package    Wpmh_Clone_Menu
 * @subpackage Wpmh_Clone_Menu/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wpmh_Clone_Menu
 * @subpackage Wpmh_Clone_Menu/includes
 * @author     Vala Bhavesh V <bhaveshvala2010@gmail.com>
 */
class Wpmh_Clone_Menu_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wpmh-clone-menu',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
