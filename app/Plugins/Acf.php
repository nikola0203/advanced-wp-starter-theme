<?php
/**
 * ACF PRO
 *
 * @link https://github.com/elliotcondon/acf
 *
 * @package awpt
 */

namespace Awpt\Plugins;

class Acf
{
	/**
	 * Register default hooks and actions for WordPress.
	 *
	 * @return
	 */
	public function register()
	{
		if ( class_exists( 'ACF' ) ) {
			add_filter( 'acf/settings/save_json', array( $this, 'json_save_point' ) );
			add_filter( 'acf/settings/load_json', array( $this, 'json_load_point' ) );
			add_action( 'after_setup_theme', array( $this, 'add_options_pages' ) );
		}
	}

	public function json_save_point( $path )
	{
		// Update path.
		$path = get_template_directory() . '/acf-json';

		return $path;
	}

	public function json_load_point( $paths )
	{
		// Remove original path (optional).
		unset( $paths[0] );

		// Append path.
		$paths[] = get_template_directory() . '/acf-json';

		return $paths;
	}

	public function add_options_pages()
	{
		acf_add_options_page(
			array(
				'page_title' => 'Theme General Settings',
				'menu_title' => 'Theme Settings',
				'menu_slug'  => 'awpt-general-settings',
				'capability' => 'edit_posts',
				'redirect'   => false,
				'icon_url'   => 'dashicons-star-filled',
			)
		);

		// acf_add_options_sub_page(
		// 	array(
		// 		'page_title'  => 'Header Settings',
		// 		'menu_title'  => 'Header',
		// 		'parent_slug' => 'awpt-general-settings',
		// 		'menu_slug'   => 'awpt-header-settings',
		// 	)
		// );
		
		// acf_add_options_sub_page(
		// 	array(
		// 		'page_title'  => 'Footer Settings',
		// 		'menu_title'  => 'Footer',
		// 		'parent_slug' => 'awpt-general-settings',
		// 		'menu_slug'   => 'awpt-footer-settings',
		// 	)
		// );

		acf_add_options_sub_page(
			array(
				'page_title'  => 'Global Sections',
				'menu_title'  => 'Global Sections',
				'parent_slug' => 'awpt-general-settings',
				'menu_slug'   => 'awpt-global-sections',
			)
		);

		// acf_add_options_sub_page(
		// 	array(
		// 		'page_title'  => 'Case Studies Settings',
		// 		'menu_title'  => 'Case Studies Settings',
		// 		'parent_slug' => 'awpt-general-settings',
		// 		'menu_slug'   => 'awpt-case-studies-settings',
		// 	)
		// );
	}

	public static function image( $image_array, $size = 'thumbnail', $css_class = '' )
	{
		if ( !empty( $image_array ) ) {
			$fullWidth    = $image_array['width'];
			$fullWidthSrc = $image_array['url'];
			
			if ( 'full' != $size ) {
				$src    = $image_array['sizes'][$size];
				$width  = $image_array['sizes'][$size . '-width'];
				$height = $image_array['sizes'][$size . '-height'];
			} else {
				$src    = $fullWidthSrc;
				$width  = $fullWidth;
				$height = $image_array['height'];
			}
	
			$image_attributes = '
				width    = "' . esc_attr( $width ) . '"
				height   = "' . esc_attr( $height ) . '"
				src      = "' . esc_url( $src ) . '"
				class    = "lazyload lazy-fade '. $css_class .'"
				alt      = "' . esc_attr( $image_array['alt'] ) . '"
				loading  = "lazy"
				decoding = "async"
			';
	
			if ( 'thumbnail' != $size ) {
				if ( 'medium' == $size ) {
					$srcset = '
						' . esc_url( $src ) . ' ' . esc_attr( $width ) . 'w,
						' . esc_url( $image_array['sizes']['medium_large'] ) . ' 768w,
						' . esc_url( $image_array['sizes']['large'] ) . ' 1024w,
						' . esc_url( $fullWidthSrc ) . ' ' . $fullWidth . 'w
					';
				}
				if ( 'medium_large' == $size ) {
					$srcset = '
						' . esc_url( $src ) . ' ' . esc_attr( $width ) . 'w,
						' . esc_url( $image_array['sizes']['medium'] ) . ' 300w,
						' . esc_url( $image_array['sizes']['large'] ) . ' 1024w,
						' . esc_url( $fullWidthSrc ) . ' ' . $fullWidth . 'w
					';
				}
				if ( 'large' == $size ) {
					$srcset = '
						' . esc_url( $src ) . ' ' . esc_attr( $width ) . 'w,
						' . esc_url( $image_array['sizes']['medium'] ) . ' 300w,
						' . esc_url( $image_array['sizes']['medium_large'] ) . ' 768w,
						' . esc_url( $fullWidthSrc ) . ' ' . $fullWidth . 'w
					';
				}
				if ( 'full' == $size ) {
					$srcset = '
						' . esc_url( $src ) . ' ' . esc_attr( $width ) . 'w,
						' . esc_url( $image_array['sizes']['medium'] ) . ' 300w,
						' . esc_url( $image_array['sizes']['medium_large'] ) . ' 768w,
						' . esc_url( $image_array['sizes']['large'] ) . ' 1024w
					';
				}
	
				$image_attributes .= 'srcset="'. $srcset .'"';
	
				$image_attributes .= 'sizes="(max-width: ' . esc_attr( $width ) . 'px) 100vw, ' . esc_attr( $width ) . 'px"';
			}

			$image_html = '<img ' . $image_attributes . '>';
	
			echo wp_kses_post( $image_html );
		}
	}
}
