<?php

namespace Awpt\Core;

/**
 * Comments.
 */
class Comments
{
  /**
   * Register default hooks and actions for WordPress.
   *
   * @return
   */
  public function register()
  {
    add_action( 'admin_init', array( $this, 'remove_and_redirect_from_admin_dashboard' ) );

    // Close comments on the front-end
    add_filter( 'comments_open', '__return_false', 20, 2 );
    add_filter( 'pings_open', '__return_false', 20, 2 );

    // Hide existing comments
    add_filter( 'comments_array', '__return_empty_array', 10, 2 );

    // Remove comments page in menu
    add_action( 'admin_menu', array( $this, 'remove_comments_page_in_menu' ) );

    // Remove comments links from admin bar
    add_action( 'init', array( $this, 'remove_comments_links_from_admin_bar' ) );

    // Disable gutemberg
    add_filter( 'gutenberg_can_edit_post_type', array( $this, 'disable_gutenberg' ), 10, 2 );
    add_filter( 'use_block_editor_for_post_type', array( $this, 'disable_gutenberg' ), 10, 2 );

    // Disable classic editor
    add_action( 'admin_head', array( $this, 'disable_classic_editor' ) );
  }

  public function remove_and_redirect_from_admin_dashboard()
  {
    // Redirect any user trying to access comments page
    global $pagenow;
  
    if ( $pagenow === 'edit-comments.php' ) {
      wp_safe_redirect( admin_url() );
      exit;
    }
  
    // Remove comments metabox from dashboard
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
  
    // Disable support for comments and trackbacks in post types
    foreach ( get_post_types() as $post_type ) {
      if ( post_type_supports( $post_type, 'comments') ) {
        remove_post_type_support( $post_type, 'comments' );
        remove_post_type_support( $post_type, 'trackbacks' );
      }
    }
  }
    
  public function remove_comments_page_in_menu()
  {
    remove_menu_page( 'edit-comments.php' );
  }

  public function remove_comments_links_from_admin_bar()
  {
    if ( is_admin_bar_showing() ) {
      remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
    }
  }
    
  /**
   * Templates and Page IDs without editor
   *
   */
  public function disable_editor( $id = false )
  {
    $excluded_templates = array(
      'tmp-testimonials.php',
    );

    $excluded_ids = array(
      // get_option( 'page_on_front' )
    );

    if( empty( $id ) )
      return false;

    $id = intval( $id );
    $template = get_page_template_slug( $id );

    return in_array( $id, $excluded_ids ) || in_array( $template, $excluded_templates );
  }

  /**
   * Disable Gutenberg by template
   *
   */
  public function disable_gutenberg( $can_edit, $post_type )
  {
    if ( ! ( is_admin() && !empty( $_GET['post'] ) ) ) {
      return $can_edit;
    }

    if ( $this->disable_editor( $_GET['post'] ) ) {
      $can_edit = false;
    }

    return $can_edit;
  }


  /**
   * Disable Classic Editor by template
   *
   */
  public function disable_classic_editor()
  {
    $screen = get_current_screen();

    if ( 'page' !== $screen->id || ! isset( $_GET['post'] ) ) {
      return;
    }

    if ( $this->disable_editor( $_GET['post'] ) ) {
      remove_post_type_support( 'page', 'editor' );
    }

  }
}