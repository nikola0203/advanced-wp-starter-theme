<?php

namespace Awpt\Core;

/**
 * Use it to write your custom functions.
 */
class OptionsPages
{
	/**
	 * Register default hooks and actions for WordPress.
	 *
	 * @return
	 */
	public function register() {
    add_action( 'admin_menu', array( $this, 'add_admin_page' ), 99 );
    add_action( 'admin_init', array( $this, 'custom_settings' ), 99 );
	}

  public function add_admin_page() {
    add_submenu_page(
      'awpt-general-settings',
      'Theme CSS Options',
      'Custom CSS',
      'manage_options',
      'awpt-custom-css',
      array( $this, 'theme_settings_page' )
    );
  }
  
  public function theme_settings_page() {
    require_once( get_template_directory() . '/template-parts/admin/custom-css.php' );
  }
  
  public function custom_settings() {
    register_setting(
      'custom-css-options',
      'awpt_admin_custom_css',
      array( $this, 'sanitize_custom_css' )
    );
    
    add_settings_section(
      'awpt-custom-css-section',
      '',
      array( $this, 'custom_css_section_callback' ),
      'awpt-custom-css'
    );
    
    add_settings_field(
      'custom-css',
      'Insert your Custom CSS',
      array( $this, 'custom_css_callback' ),
      'awpt-custom-css',
      'awpt-custom-css-section'
    );
  }
  
  public function custom_css_section_callback() {
    // echo 'Customize Theme with your own CSS';
  }
  
  public function sanitize_custom_css( $input ){
    $output = esc_textarea( $input );
    return $output;
  }
  
  public function custom_css_callback() {
    $css = get_option( 'awpt_admin_custom_css' );
    
    $html = '<div id="awpt-custom-css-wrapper">' . $css . '</div>';
    $html .= '<textarea id="awpt_admin_custom_css" name="awpt_admin_custom_css" style="display:none;visibility:hidden;">' . $css . '</textarea>';

    echo $html;
  }
}