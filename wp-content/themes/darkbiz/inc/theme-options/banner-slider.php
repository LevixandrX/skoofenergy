<?php

if( !function_exists( 'darkbiz_acb_type_cat' ) ):
	/**
	* Active callback function of header top bar
	*
	* @static
	* @access public
	* @return boolen
	* @since 1.0.0
	*
	* @package Darkbiz WordPress Theme
	*/
	function darkbiz_acb_type_cat( $control ){
		$enable = $control->manager->get_setting( Darkbiz_Helper::with_prefix( 'show-slider' ) )->value();
		$cat = $control->manager->get_setting( Darkbiz_Helper::with_prefix( 'slider-type' ) )->value();
		$val = $enable && 'category' == $cat;
		return $val;
	}
endif;

if( !function_exists( 'darkbiz_acb_slider' ) ):
	/**
	* Active callback function of slider
	*
	* @static
	* @access public
	* @return boolen
	* @since 1.0.0
	*
	* @package Darkbiz WordPress Theme
	*/
	function darkbiz_acb_slider( $control ){
		$val = $control->manager->get_setting( Darkbiz_Helper::with_prefix( 'show-slider' ) )->value();
		return $val;
	}
endif;

/**
* Banner Slider Options
*
* @return void
* @since 1.0.0
*
* @package Darkbiz WordPress Theme
*/
function darkbiz_slider_options(){

	Darkbiz_Customizer::set(array(
		# Theme option
		'panel' => 'panel',
		# Theme Option > Header
		'section' => array(
		    'id'    => 'slider',
		    'title' => esc_html__( 'Home Page Slider', 'darkbiz' ),
		    'priority' => 0
		),
		# Theme Option > Header > settings
		'fields' => array(
			array(
			    'id'	  => 'show-slider',
			    'label'   => esc_html__( 'Enable Slider', 'darkbiz' ),
			    'default' => true,
			    'type'    => 'darkbiz-toggle',
			),
			array(
				'id' => 'slider-more-text',
				'label' => esc_html__( 'Read More Text', 'darkbiz' ),
				'default' => esc_html__( 'Read More', 'darkbiz' ),
				'active_callback' => 'acb_slider',
				'type' => 'text'
			),
			array(
			    'id'      => 'slider-type',
			    'label'   => esc_html__( 'Get Content From', 'darkbiz' ),
			    'type'    => 'darkbiz-buttonset',
			    'default' => 'category',
			    'active_callback' => 'acb_slider',
			    'choices' => array(
			        'post' => esc_html__( 'Recent Post', 'darkbiz' ),
			        'category'  => esc_html__( 'Category', 'darkbiz' ),
			    )
			),
			array(
				'id' => 'cat-post',
				'label' => esc_html__( 'Select Category', 'darkbiz' ),
				'default' => 0,
				'type' => 'darkbiz-category-dropdown',
				'active_callback' => 'acb_type_cat'
			)
		)
	));
}
add_action( 'init', 'darkbiz_slider_options' );