<?php

namespace Awpt\Core;

use WP_Block_Type_Registry;

/**
 * Blocks.
 */
class Blocks
{
  /**
   * Register default hooks and actions for WordPress.
   *
   * @return
   */
  public function register()
  {
    add_filter( 'allowed_block_types_all', array( $this, 'blacklist_blocks' ) );
  }

  public function blacklist_blocks( $allowed_blocks )
  {
    // get all the registered blocks
    $blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

    // then disable some of them
    unset( $blocks[ 'core/navigation' ] );
    unset( $blocks[ 'core/latest-posts' ] );

    // return the new list of allowed blocks
    return array_keys( $blocks );
  }
}