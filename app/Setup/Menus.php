<?php

namespace Awpt\Setup;

/**
 * Menu.
 */
class Menus
{
  /**
   * Register default hooks and actions for WordPress.
   *
   * @return
   */
  public function register()
  {
    add_action( 'after_setup_theme', array( $this, 'menus' ) );
  }

  public function menus()
  {
    register_nav_menus(
      array(
        'primary' => esc_html__( 'Primary Menu', 'awpt' ),
      )
    );
  }
}