<?php
/**
 * Create options for posts.
 *
 * @since 1.0.0
 *
 * @package Darkbiz WordPress theme
 */

function darkbiz_post_options(){  
    Darkbiz_Customizer::set(array(
    	# Theme Options
    	'panel'   => 'panel',
    	# Theme Options > Page Options > Settings
    	'section' => array(
    		'id'    => 'post-options',
    		'title' => esc_html__( 'Post Options','darkbiz' ),
    	),
    	'fields' => array(
            array(
                'id'      => 'post-category',
                'label'   =>  esc_html__( 'Show Categories', 'darkbiz' ),
                'default' => 1,
                'type'    => 'darkbiz-toggle',
            ),
            array(
                'id'      => 'post-date',
                'label'   => esc_html__( 'Show Date', 'darkbiz' ),
                'default' => 1,
                'type'    => 'darkbiz-toggle',
            ),
            array(
                'id'      => 'post-author',
                'label'   =>  esc_html__( 'Show Author', 'darkbiz' ),
                'default' => 1,
                'type'    => 'darkbiz-toggle',
            ),
            array(
                'id'      => 'excerpt_length',
                'label'   => esc_html__( 'Excerpt Length', 'darkbiz' ),
                'description' => esc_html__( 'Defaults to 10.', 'darkbiz' ),
                'default' => 10,
                'type'    => 'number',
            ),
            array(
                'id'      => 'read-more-text',
                'label'   => esc_html__( 'Read More Text', 'darkbiz' ),
                'default' => esc_html__( 'Read More', 'darkbiz' ),
                'type'    => 'text'
            ),
            array(
                'id' => 'post-per-row',
                'label' => esc_html__( 'Post Per Row', 'darkbiz' ),
                'type' => 'darkbiz-buttonset',
                'default' => '2',
                'choices' => array(
                    '1' => esc_html__( '1', 'darkbiz' ),
                    '2' => esc_html__( '2', 'darkbiz' ),
                    '3' => esc_html__( '3', 'darkbiz' ),
                    '4' => esc_html__( '4', 'darkbiz' )
                )
            ),
     	),
    ) );
}
add_action( 'init', 'darkbiz_post_options' );