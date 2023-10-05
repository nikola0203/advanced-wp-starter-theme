<?php

namespace Awpt\Custom;

/**
 * Use it to write your custom filters.
 */
class Filters
{
  public function register()
  {
    add_filter( 'excerpt_length', array( $this, 'custom_excerpt_length' ), 99 );
    add_filter( 'excerpt_more', array( $this, 'excerpt_more' ), 99 );
  }

  function custom_excerpt_length( $length )
  {
    return 30;
  }

  public function excerpt_more( $more ) {
    return '...';
  }
}
