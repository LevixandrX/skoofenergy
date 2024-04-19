<?php
/**
 * Resets all the value of customizer
 *
 * @since 1.0.0
 *
 * @package Darkbiz WordPress Theme
 */

if( !function_exists( 'darkbiz_get_setting_id' ) ):
	add_action( 
		Darkbiz_Helper::fn_prefix( 'customize_register_start' ), 
		'darkbiz_get_setting_id', 30, 2 );
	/**
	* Get all the setting id to darkbiz-reset the data.
	*
	* @return array
	* @since 1.0.0
	*
	* @package Darkbiz WordPress theme
	*/
	function darkbiz_get_setting_id( $instance, $wp_customize ) {
		
		Darkbiz_Customizer::set(array(
			# Theme option
			'panel' => 'panel',
			# Theme Option > Reset options
			'section' => array(
			    'id'    => 'darkbiz-reset-section',
			    'title' => esc_html__( 'Reset Options' ,'darkbiz' ),
			),
			'fields' => array(
				array(
				    'id' 	      => 'darkbiz-reset-options',
				    'type'        => 'darkbiz-reset',
				    'settings'    => array_keys( $instance::$settings ),
				    'label'       => esc_html__( 'Reset', 'darkbiz' ),
				    'description' => esc_html__( 'Reseting will delete all the data. Once darkbiz-reset, you will not be able to get back those data.', 'darkbiz' ),
				),
			),
		) );
	}
endif;
