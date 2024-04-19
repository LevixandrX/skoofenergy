<?php
/**
 * Inner banner options in customizer
 *
 * @return void
 * @since 1.0.0
 *
 * @package Darkbiz WordPress Theme
 */

function darkbiz_inner_banner_options(){ 
	Darkbiz_Customizer::set(array(
		# Theme Option > color options
		'section' => array(
		    'id'       => 'header_image',
		    'priority' => 27,
		    'prefix' => false,
		),
		'fields'  => array(
			array(
				'id'      	  => 'ib-blog-title',
				'label'   	  => esc_html__( 'Title' , 'darkbiz' ),
				'description' => esc_html__( 'It is displayed when home page is latest posts.' , 'darkbiz' ),
				'default' 	  => esc_html__( 'Latest Blog' , 'darkbiz' ),
				'type'	  	  => 'text',
				'priority'    => 10,
			),
		    array(
		        'id'	  	  => 'ib-title-size',
		        'label'   	  => esc_html__( 'Font Size', 'darkbiz' ),
		        'default' => array(
		    		'desktop' => 40,
		    		'tablet'  => 32,
		    		'mobile'  => 32,
		    	),
				'input_attrs' =>  array(
		            'min'   => 1,
		            'max'   => 60,
		            'step'  => 1,
		        ),
		        'type' => 'darkbiz-slider',
		        'priority' => 20
		    ),
		    array(
		        'id'      => 'ib-title-color',
		        'label'   => esc_html__( 'Text Color' , 'darkbiz' ),
		        'type'    => 'darkbiz-color-picker',
		        'default' => '#ffffff',
		        'priority' => 30
		    ),
		    array(
		    	'id' 	   => 'ib-background-color',
		    	'label'    => esc_html__( 'Overlay Color', 'darkbiz' ),
		    	'default'  => 'rgba(0, 0, 0, 0.49)',
		    	'type' 	   => 'darkbiz-color-picker',
		    	'priority' => 40,
		    ),
		    array(
		        'id'      => 'ib-text-align',
		        'label'   => esc_html__( 'Alignment' , 'darkbiz' ),
		        'type'    => 'darkbiz-buttonset',
		        'default' => 'banner-content-center',
		        'choices' => array(
		        	'banner-content-left'   => esc_html__( 'Left' , 'darkbiz'   ),
		        	'banner-content-center' => esc_html__( 'Center' , 'darkbiz' ),
		        	'banner-content-right'  => esc_html__( 'Right' , 'darkbiz'  ),
		         ),
		        'priority' => 50
		    ),
			array(
			    'id'      => 'ib-image-attachment', 
			    'label'   => esc_html__( 'Image Attachment' , 'darkbiz' ),
			    'type'    => 'darkbiz-buttonset',
			    'default' => 'banner-background-scroll',
			    'choices' => array(
			    	'banner-background-scroll'           => esc_html__( 'Scroll' , 'darkbiz' ),
			    	'banner-background-attachment-fixed' => esc_html__( 'Fixed' , 'darkbiz' ),
			    ),
		        'priority' => 60
			),
			array(
			    'id'      	=> 'ib-height',
			    'label'   	=> esc_html__( 'Height (px)', 'darkbiz' ),
			    'type'    	=> 'darkbiz-slider',
	            'default' => array(
	        		'desktop' => 300,
	        		'tablet'  => 300,
	        		'mobile'  => 300,
	        	),
	    		'input_attrs' =>  array(
	                'min'   => 1,
	                'max'   => 1000,
	                'step'  => 1,
	            ),
			),
		    'priority' => 70
		),
	) );
}
add_action( 'init', 'darkbiz_inner_banner_options' );