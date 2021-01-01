<?php
/**
 * Theme Customizer - Footer.
 *
 * @package awpt
 */

namespace Awpt\Api\Customizer;

use WP_Customize_Control;
use WP_Customize_Color_Control;

use Awpt\Api\Customizer;

/**
 * Customizer class
 */
class Footer
{
	/**
	 * Register default hooks and actions for WordPress.
	 *
	 * @param object $wp_customize
	 * @return
	 */
	public function register( $wp_customize ) 
	{
		$wp_customize->add_section(
			'awpt_footer_section',
			array(
				'title'       => __( 'Footer', 'awpt' ),
				'description' => __( 'Customize the Footer' ),
				'priority'    => 162
			)
		); 

		$wp_customize->add_setting(
			'awpt_footer_background_color', array(
				'default'   => '#ffffff',
				'transport' => 'postMessage', // or refresh if you want the entire page to reload.
			)
		);

		$wp_customize->add_setting(
			'awpt_footer_copy_text', array(
				'default'   => 'Proudly powered by awpt',
				'transport' => 'postMessage', // or refresh if you want the entire page to reload.
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'awpt_footer_background_color',
				array(
					'label'    => __( 'Background Color', 'awpt' ),
					'section'  => 'awpt_footer_section',
					'settings' => 'awpt_footer_background_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'awpt_footer_copy_text',
				array(
					'label'    => __( 'Copyright Text', 'awpt' ),
					'section'  => 'awpt_footer_section',
					'settings' => 'awpt_footer_copy_text',
				)
			)
		);

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'awpt_footer_background_color',
				array(
					'selector'         => '#awpt-footer-control',
					'render_callback'  => array( $this, 'outputCss' ),
					'fallback_refresh' => true
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'awpt_footer_copy_text',
				array(
					'selector'         => '#awpt-footer-copy-control',
					'render_callback'  => array( $this, 'outputText' ),
					'fallback_refresh' => true
				)
			);
		}
	}

	/**
	 * Generate inline CSS for customizer async reload.
	 *
	 * @return CSS
	 */
	public function outputCss()
	{
		echo '<style type="text/css">';
			echo Customizer::css( '.site-footer', 'background-color', 'awpt_footer_background_color' );
		echo '</style>';
	}

	/**
	 * Generate inline text for customizer async reload.
	 *
	 * @return
	 */
	public function outputText()
	{
		echo Customizer::text( 'awpt_footer_copy_text' );
	}
}