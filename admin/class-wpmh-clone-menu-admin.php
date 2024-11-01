<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://valabhavesh.wordpress.com
 * @since      1.0.0
 *
 * @package    Wpmh_Clone_Menu
 * @subpackage Wpmh_Clone_Menu/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpmh_Clone_Menu
 * @subpackage Wpmh_Clone_Menu/admin
 * @author     Vala Bhavesh V <bhaveshvala2010@gmail.com>
 */
class Wpmh_Clone_Menu_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wpmh_clone_menu_enqueue_styles() {

		/**
		 * This function is provided for wp_enqueue_style purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpmh_Clone_Menu_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpmh_Clone_Menu_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$get_current_screen = get_current_screen();
		global $wpmh_clone_menu_id;		
		if ( $get_current_screen->id == $wpmh_clone_menu_id ) {		
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpmh-clone-menu-admin.css', array(), $this->version.time(), 'all' );
		}
		

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wpmh_clone_menu_enqueue_scripts() {

		/**
		 * This function is provided for wp_enqueue_script purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpmh_Clone_Menu_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpmh_Clone_Menu_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */		
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpmh-clone-menu-admin.js', array( 'jquery' ), $this->version, true );

		wp_localize_script($this->plugin_name, 'wpmh_script_object', array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'plugin_url' => WPMH_CLONE_MENU_URL,
				'wp_get_nav_menus' => wp_get_nav_menus(),
				'wp_get_nav_menus_count' => count(wp_get_nav_menus()),
			)
		);

		

	}

	public function wpmh_clone_menu_clone_setting_page() {

		/**
		 * This function is provided for admin menu purposes only.
		 * Registers page in wordpress backend.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpmh_Clone_Menu_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpmh_Clone_Menu_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $wpmh_clone_menu_id;
		$wpmh_clone_menu_id = add_menu_page( 'WPMH Clone Menu', 'WPMH Clone Menu', 'manage_options', 'wpmh-clone-menu', array( $this, 'wpmh_clone_menu_cloner_page' ), WPMH_CLONE_MENU_URL . 'admin/images/experimental-documents-arcadeX20.png' , 9999 );
	}

	public function wpmh_clone_menu_cloner_page() {

		/**
		 * This function is provided for admin menu display purposes only.		  
		 * 		 
		 */

		include_once( WPMH_CLONE_MENU_PATH . 'admin/partials/wpmh-clone-menu-admin-display.php' );
	}

	function wpmh_clone_menu_callback() {

	if ( isset( $_POST ) ) {

		$new_name = sanitize_text_field( $_POST['new_name'] );
		$menu_id  = intval( $_POST['menu_id'] );

		$old_menu       = wp_get_nav_menu_object( $menu_id );
		$old_menu_items = wp_get_nav_menu_items( $menu_id );

		$new_menu_id = wp_create_nav_menu( $new_name );

		if ( ! $new_menu_id ) {
			$new_menu_id = 0;
		} else {

			// key is the original db ID, val is the new
			$rel = array();

			$i = 1;
			foreach ( $old_menu_items as $menu_item ) {
				$args = array(
					'menu-item-db-id'       => $menu_item->db_id,
					'menu-item-object-id'   => $menu_item->object_id,
					'menu-item-object'      => $menu_item->object,
					'menu-item-position'    => $i,
					'menu-item-type'        => $menu_item->type,
					'menu-item-title'       => $menu_item->title,
					'menu-item-url'         => $menu_item->url,
					'menu-item-description' => $menu_item->description,
					'menu-item-attr-title'  => $menu_item->attr_title,
					'menu-item-target'      => $menu_item->target,
					'menu-item-classes'     => implode( ' ', $menu_item->classes ),
					'menu-item-xfn'         => $menu_item->xfn,
					'menu-item-status'      => $menu_item->post_status
				);

				$parent_id = wp_update_nav_menu_item( $new_menu_id, 0, $args );

				$rel[ $menu_item->db_id ] = $parent_id;

				if ( $menu_item->menu_item_parent ) {
					$args['menu-item-parent-id'] = $rel[ $menu_item->menu_item_parent ];
					$parent_id                   = wp_update_nav_menu_item( $new_menu_id, $parent_id, $args );
				}

				$i ++;
			}
		}
		echo intval($new_menu_id);
	}
	wp_die();
}

}
