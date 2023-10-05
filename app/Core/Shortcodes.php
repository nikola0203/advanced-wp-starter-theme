<?php

namespace Awpt\Core;

use WP_Query;

/**
 * Shortcodes.
 */
class Shortcodes
{
  /**
   * Register default hooks and actions for WordPress.
   *
   * @return
   */
  public function register()
  {
    add_filter( 'widget_text', 'do_shortcode' );
    add_shortcode( 'year', array( $this, 'display_current_year' ) );
  }

  public function display_current_year()
  { 
    return date( 'Y' );
  }
}
