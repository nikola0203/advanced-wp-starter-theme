<?php
/**
 * Front Page template
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#front-page-display
 *
 * @package seo_one_click_theme
 */

get_header();
?>
<main id="post-<?php the_ID(); ?>" <?php post_class( 'site-main' ); ?>>
	<?php the_content(); ?>
</main><!-- #main -->
<?php
get_footer();
