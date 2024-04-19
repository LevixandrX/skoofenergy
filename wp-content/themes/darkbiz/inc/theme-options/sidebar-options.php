<?php
/**
* Register sidebar Options
*
* @return void
* @since 1.0.0
*
* @package Darkbiz WordPress theme
*/
function darkbiz_sidebar_options(){
	Darkbiz_Customizer::set(array(
		# Theme Options
		'panel'   => 'panel',
		# Theme Options >Sidebar Layout > Settings
		'section' => array(
			'id'     => 'sidebar-options',
			'title'  => esc_html__( 'Sidebar Options','darkbiz' ),
		),
		'fields' => array(
			# sb - Sidebar
			array(
			    'id'      => 'sidebar-position',
			    'label'   => esc_html__( 'Sidebar Position' , 'darkbiz' ),
			    'type'    => 'darkbiz-buttonset',
			    'default' => 'right-sidebar',
			    'choices' => array(
			        'left-sidebar'  => esc_html__( 'Left' , 'darkbiz' ),
			        'right-sidebar' => esc_html__( 'Right' , 'darkbiz' ),
			        'no-sidebar'    => esc_html__( 'None', 'darkbiz' ),
			     )
			),
		),
	) );
}
add_action( 'init', 'darkbiz_sidebar_options' );