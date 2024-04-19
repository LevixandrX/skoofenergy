<?php
if( !function_exists( 'darkbiz_acb_custom_header_one' ) ):
	/**
	* Active callback function of header top bar
	*
	* @static
	* @access public
	* @return boolen
	* @since 1.0.0
	*
	* @package Darkbiz WordPress theme
	*/
	function darkbiz_acb_custom_header_one( $control ){
		$value = $control->manager->get_setting( Darkbiz_Helper::with_prefix( 'container-width' ) )->value();
		return 'default' == $value;
	}
endif;

/**
* Register Advanced Options
*
* @return void
* @since 1.0.0
*
* @package Darkbiz WordPress theme
*/
function darkbiz_advanced_options(){

	Darkbiz_Customizer::set(array(
		# Theme option
		'panel' => 'panel',
		# Theme Option > Header
		'section' => array(
		    'id'    => 'advance-options',
		    'title' => esc_html__( 'Advanced Options', 'darkbiz' ),
		),
		# Theme Option > Header > settings
		'fields' => array(
			array(
				'id'	=> 'pre-loader',
				'label' => esc_html__( 'Show Preloader', 'darkbiz' ),
				'default' => false,
				'type'  => 'darkbiz-toggle',
			),
			array(
			    'id'      => 'assets-version',
			    'label'   => esc_html__( 'Assets Version', 'darkbiz' ),
			    'type'    => 'darkbiz-buttonset',
			    'default' => 'development',
			    'choices' => array(
			        'development' => esc_html__( 'Development', 'darkbiz' ),
			        'production'  => esc_html__( 'Production', 'darkbiz' ),
			    )
			),
			array(
			    'id'      =>  'container-width',
			    'label'   => esc_html__( 'Site Layout', 'darkbiz' ),
			    'type'    => 'darkbiz-buttonset',
			    'default' => 'default',
			    'choices' => array(
			        'default' => esc_html__( 'Default', 'darkbiz' ),
			        'box'	  => esc_html__( 'Boxed', 'darkbiz' ),
			    )
			),
		    array(
		        'id'          	  => 'container-custom-width',
		        'label'   	  	  => esc_html__( 'Container Width', 'darkbiz' ),
		        'active_callback' => 'acb_custom_header_one',
		        'type'        	  => 'darkbiz-range',
		        'default'     	  => '1140',
	    		'input_attrs' 	  =>  array(
	                'min'   => 400,
	                'max'   => 2000,
	                'step'  => 5,
	            ),
		    ),
		)
	));
}
add_action( 'init', 'darkbiz_advanced_options' );