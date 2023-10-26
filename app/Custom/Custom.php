<?php

namespace Awpt\Custom;

/**
 * Use it to write your custom functions.
 */
class Custom
{
  public static function get_post_categories()
  {
    $categories = get_categories();
    $count      = count( $categories );

    if ( ! empty( $categories ) ) {
      echo '&nbsp;|&nbsp;';
      foreach( $categories as $key => $category ) {
        echo '<div class="text-uppercase"><a href="' . get_category_link( $category->term_id ) . '" class="text-gray-600 text-decoration-underline">' . $category->name . '</a></div>';
        if ( $count > 1 && ( $key + 1 ) != $count ) {
          echo ',&nbsp;';
        }
      }
    }
  }

  /**
   * Post ID
   *
   * @param int $post_id
   * @return void
   */
  public static function reading_time( $post_id )
  {
    $content     = get_post_field( 'post_content', $post_id );
    $word_count  = str_word_count( strip_tags( $content ) );
    $readingtime = ceil( $word_count / 200 );
    
    if ( $readingtime == 1 ) {
      $timer = "min read";
    } else {
      $timer = "min read";
    }

    $totalreadingtime = $readingtime . $timer;

		echo '<span class="fw-bold post-read-time"> ' . $totalreadingtime . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
  }

  /**
   * Display site logo.
   */
  public static function site_logo()
  {
    if ( ! class_exists('ACF') ) {
      return false;
    }

    $headerSettings = get_field( 'header_settings', 'option' );
    if ( ! empty( $headerSettings['site_logo'] ) ) {
      ?>
      <a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>" class="custom-logo-link">
        <img src="<?php echo esc_url( $headerSettings['site_logo']['sizes']['medium'] ); ?>" width="<?php esc_attr_e( $headerSettings['site_logo']['width'] ); ?>" height="<?php esc_attr_e( $headerSettings['site_logo']['height'] ); ?>" class="w-100 custom-logo" alt="<?php bloginfo( 'name' ); ?>">
      </a>
      <?php
    }
  }

  /**
	 * Custom get excerpt
	 *
	 * @param int $limit
	 * @param string $source
	 * @return void
	 */
	public static function get_excerpt( $limit, $source = null )
  {
		$excerpt = $source == "content" ? get_the_content() : get_the_excerpt();
		$excerpt = preg_replace( " (\[.*?\])",'',$excerpt );
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = strip_tags( $excerpt);
		$excerpt = substr( $excerpt, 0, $limit );
		$excerpt = substr( $excerpt, 0, strripos( $excerpt, " " ) );
		$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt ) );
		// $excerpt = $excerpt . '... <a href="' . get_permalink( get_the_ID() ) . '">' . esc_html( 'read more', 'seo_one_click_theme' ) . '</a>';
		$excerpt = $excerpt . '...';
		return $excerpt;
	}

  public static function get_recent_posts()
  {
    $args = array(
      'posts_per_page' => 3,
      'post_type'      => 'post',
      'post_status'    => 'publish',
      'orderby'        => 'post_date',
      'order'          => 'DESC'
    );

    $recent_posts = new \WP_Query( $args );

    if ( $recent_posts->have_posts() ) {
      ?>
      <div class="section-recent-posts my-10 my-lg-18">
        <div class="container">
          <div class="row">
            <div class="col-12 col-md">
              <h2>Read more posts</h2>
            </div>
            <div class="col-12 col-md d-none d-md-flex align-items-md-end justify-content-md-end mb-7 mb-sm-0">
              <a href="<?php echo get_post_type_archive_link( 'post' ); ?>" class="fw-bold link-view-all-posts">View all&nbsp;<i class="fas fa-chevron-right text-secondary ms-3"></i></a>
            </div>
          </div>
          <div class="row">
            <?php
            while ( $recent_posts->have_posts() ) {
              $recent_posts->the_post();
              ?>
              <div class="col-md-6 col-lg-4 mb-8 mb-lg-0">
                <div class="recent-posts-image mb-6">
                  <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail( 'medium_large' ); ?>
                  </a>
                </div>
                <div class="entry-meta mb-4">
                  <span class="entry-meta-posted-on fw-bold pe-6 relative">
                    <?php Tags::posted_on(); ?>
                  </span>
                  <?php Tags::reading_time( get_the_ID() ); ?>
                </div>
                <a href="<?php the_permalink(); ?>"><h3 class="mb-6"><?php the_title(); ?></h3></a>
                <div class="recent-posts-excerpt mb-6">
                  <?php the_excerpt(); ?>
                </div>
                <a href="<?php the_permalink(); ?>" class="fw-bold link-view-all-posts">Read more <i class="fas fa-chevron-right text-secondary ms-3"></i></a>
              </div>
              <?php
            }
            wp_reset_postdata();
            ?>
          </div>
          <a href="<?php echo get_post_type_archive_link( 'post' ); ?>" class="btn btn-white w-100 justify-content-center d-md-none">View all&nbsp;<span class="icon-btn"><?php echo seo_one_click_theme_get_svg_icon( icon_arrow_right('#559e33') ); ?></span></a>
        </div>
      </div>
      <?php
    } else {
			get_template_part( 'template-parts/content', 'none' );
    }
  }
}