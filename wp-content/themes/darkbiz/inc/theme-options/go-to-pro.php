<?php
/**
* Register Go to pro button
*
* @since 1.0.1
*
* @package Darkbiz WordPress Theme
*/
function suit_press_go_to_pro(){
	Darkbiz_Customizer::set(array(
		'section' => array(
			'id'       => 'go-to-pro', 
			'type'     => 'darkbiz-anchor',
			'title'    => esc_html__( 'DarkBiz Pro', 'darkbiz' ),
			'url'      => esc_url( 'https://wpactivethemes.com/downloads/darkbiz-pro/' ),
			'priority' => 0
		)
	));
}
add_action( 'init', 'suit_press_go_to_pro' );