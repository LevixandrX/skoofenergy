<?php
/**
* Register blog Options
*
* @return void
* @since 1.0.0
*
* @package Darkbiz WordPress theme
*/
function darkbiz_blog_options(){	
	Darkbiz_Customizer::set(array(
		# Theme option
		'panel' => 'panel',
		# Theme Option > color options
		'section' => array(
		    'id'       => 'blog-section',
		    'title'    => esc_html__( 'Blog Options' ,'darkbiz' ),
		    'priority' => 25
		),
		'fields'  => array(
			array(
				'id'	=> 'meta-sections-order',
				'label' => esc_html__( 'Archive Meta Order', 'darkbiz' ),
				'description' => esc_html__( 'Please make sure that you have enabled all sections under "Post Options"', 'darkbiz' ),
				'type'  => 'darkbiz-section-order',
				'default' =>json_encode(array(
					'title', 'date', 'category', 'excerpt', 'comment'
				)),
				'choices' => array(
					'title' => esc_html__( 'Title', 'darkbiz' ),
					'date' => esc_html__( 'Date', 'darkbiz' ),
					'category' => esc_html( 'Category', 'darkbiz' ),
					'excerpt' => esc_html__( 'Excerpt', 'darkbiz' ),
					'comment' => esc_html__( 'Comment', 'darkbiz' )
				),
				'transport'   => 'refresh'
			),
		),			
	));
}
add_action( 'init', 'darkbiz_blog_options' );
