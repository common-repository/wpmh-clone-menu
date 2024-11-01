<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://valabhavesh.wordpress.com
 * @since      1.0.0
 *
 * @package    Wpmh_Clone_Menu
 * @subpackage Wpmh_Clone_Menu/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wpmh_Clone_Menu
 * @subpackage Wpmh_Clone_Menu/includes
 * @author     Vala Bhavesh V <bhaveshvala2010@gmail.com>
 */
class Wpmh_Clone_Menu {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wpmh_Clone_Menu_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WPMH_CLONE_MENU_VERSION' ) ) {
			$this->version = WPMH_CLONE_MENU_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wpmh-clone-menu';

		$this->wpmh_clone_menu_load_dependencies();
		$this->wpmh_clone_menu_set_locale();
		$this->wpmh_clone_menu_define_admin_hooks();
		$this->wpmh_clone_menu_define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wpmh_Clone_Menu_Loader. Orchestrates the hooks of the plugin.
	 * - Wpmh_Clone_Menu_i18n. Defines internationalization functionality.
	 * - Wpmh_Clone_Menu_Admin. Defines all hooks for the admin area.
	 * - Wpmh_Clone_Menu_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function wpmh_clone_menu_load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpmh-clone-menu-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpmh-clone-menu-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpmh-clone-menu-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wpmh-clone-menu-public.php';

		$this->loader = new Wpmh_Clone_Menu_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wpmh_Clone_Menu_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function wpmh_clone_menu_set_locale() {

		$plugin_i18n = new Wpmh_Clone_Menu_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function wpmh_clone_menu_define_admin_hooks() {

		$plugin_admin = new Wpmh_Clone_Menu_Admin( $this->wpmh_clone_menu_get_plugin_name(), $this->wpmh_clone_menu_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'wpmh_clone_menu_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'wpmh_clone_menu_enqueue_scripts' );
		$this->loader->add_action( 'admin_menu',$plugin_admin, 'wpmh_clone_menu_clone_setting_page' );
		$this->loader->add_action( 'wp_ajax_menu_callback',$plugin_admin, 'wpmh_clone_menu_callback' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function wpmh_clone_menu_define_public_hooks() {

		$plugin_public = new Wpmh_Clone_Menu_Public( $this->wpmh_clone_menu_get_plugin_name(), $this->wpmh_clone_menu_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'wpmh_clone_menu_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'wpmh_clone_menu_enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function wpmh_clone_menu_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wpmh_Clone_Menu_Loader    Orchestrates the hooks of the plugin.
	 */
	public function wpmh_clone_menu_get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function wpmh_clone_menu_get_version() {
		return $this->version;
	}

}
