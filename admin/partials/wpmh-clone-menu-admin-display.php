<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://valabhavesh.wordpress.com
 * @since      1.0.0
 *
 * @package    Wpmh_Clone_Menu
 * @subpackage Wpmh_Clone_Menu/admin/partials
 */
$wp_get_nav_menu_items = wp_get_nav_menus();
?>
<div id="wpmhmain">
    <div class="wpmh-group-main-section wrap cloner-section">
       <header class="wpmh-group-admin-plugin-header">
          <div class="wpmh-group-dl">
             <div class="wpmh-group-header-L">
                <div class="wpmh-group-plugin-header-logo-section">
                   <div class="wpmh-group-plugin-header-logo-img">
                      <img src="<?php echo esc_url( WPMH_CLONE_MENU_URL . 'admin/images/experimental-documents-arcade.png' ); ?>">
                   </div>
                </div>
                <div class="wpmh-group-heading">
                   <div class="heading"><?php _e( 'WPMH Clone Menus '.WPMH_CLONE_MENU_VERSION, 'wpmh-clone-menu' ); ?></div>
                   <div class="short-details"><?php _e( 'This plugin is easy to use for copy the menus from simply the existing menu which you want to duplicate and enter a new name for copy menu. And quickly duplicate a menu in WordPress.', 'wpmh-clone-menu' ); ?></div>
                </div>
             </div>
          </div>      
       </header>
       <div class="wcblu-col-container wpmh-group-pl-colne-table">      
          <div class="wpmh-group-table-start">
             <div class="wpmh-group-pl-title">
                <h2><?php _e( 'WPMH Clone Menus', 'wpmh-clone-menu' ); ?>
                    <span id="response"></span>                    
                </h2>

             </div>
          </div>
          <table class="wpmh-group-pl-table-off main-clone">
             <tbody>
                <?php if ( empty( $wp_get_nav_menu_items ) ) { ?>
                    <tr>
                        <th><p>
                           <?php
                           printf( 
                               __('No any menus found yet. Please create 1st menu %s', 'wpmh-clone-menu'), 
                               '<a href="'.esc_url( site_url( 'wp-admin/nav-menus.php' ) ).'">click here</a>'
                           ); 
                           ?>
                        </p></th>
                    </tr>
                <?php }else{ ?> 
                    <tr>
                       <th scope="row" class="wpmh-group-pl-head-detail-section"><label for=""><?php _e( 'Menus', 'wpmh-clone-menu'); ?></label>
                       </th>
                       <td>
                          <select name="wpmh_group_menus_exist" id="wp_get_nav_menu_items" class="classic">
                             <option value=""><?php _e( 'Select Menu', 'wpmh-clone-menu'); ?></option>
                             <?php if($wp_get_nav_menu_items){ ?>
                                <?php foreach ( $wp_get_nav_menu_items as $menu ) { ?>
                                    <option value="<?php echo esc_attr($menu->term_id); ?>"><?php esc_html_e( $menu->name, 'wpmh-clone-menu' ); ?></option>
                                <?php } ?>
                             <?php } ?>
                          </select>
                          <p id="responseError_wpmh_group_menus_exist"></p>
                       </td>
                    </tr>
                    <tr>
                       <th scope="row" class="wpmh-group-pl-head-detail-section">
                          <label><?php _e( 'Clone Menu Name', 'wpmh-clone-menu'); ?></label>                         
                       </th>
                       <td>
                          <input type="text" name="clone_menu_name" id="clone_menu_name" placeholder="<?php _e( 'Enter the new name', 'wpmh-clone-menu'); ?>">                  
                          <p id="responseError_clone_menu_name"></p>
                       </td>
                    </tr>
                <?php } ?>
             </tbody>
          </table>
          <?php if (!empty( $wp_get_nav_menu_items ) ) { ?>
              <p><input id="wpmh_group_clone_btn" type="button" class="button button-primary" value="<?php _e( 'Clone', 'wpmh-clone-menu'); ?>"></p>
          <?php } ?>
       </div>
       <div class="wpmh-group-sidebar">
          <div class="wpmh-group-main-sidebar-start">
             <div class="wpmh-group-sidebar-center-area">
                <h3><?php _e( 'You Like This Plugin?', 'wpmh-clone-menu'); ?></h3>
                <div class="wpmh-group-star-rating">
                   <input type="radio" id="5-stars" name="rating" value="<?php _e( '5', 'wpmh-clone-menu'); ?>">
                   <label for="5-stars" class="star"></label>
                   <input type="radio" id="4-stars" name="rating" value="<?php _e( '4', 'wpmh-clone-menu'); ?>">
                   <label for="4-stars" class="star"></label>
                   <input type="radio" id="3-stars" name="rating" value="<?php _e( '3', 'wpmh-clone-menu'); ?>">
                   <label for="3-stars" class="star"></label>
                   <input type="radio" id="2-stars" name="rating" value="<?php _e( '2', 'wpmh-clone-menu'); ?>">
                   <label for="2-stars" class="star"></label>
                   <input type="radio" id="1-star" name="rating" value="<?php _e( '1', 'wpmh-clone-menu'); ?>">
                   <label for="1-star" class="star"></label>                   
                </div>
                <p><?php _e( 'Your Review is very important to us as it helps us to grow more.', 'wpmh-clone-menu'); ?></p>
             </div>
          </div>      
       </div>
    </div>
</div>