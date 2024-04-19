<?php
/**
* Register breadcrumb Options
*
* @return void
* @since 1.0.0
*
* @package Darkbiz WordPress theme
*/
function darkbiz_color_options(){	
	Darkbiz_Customizer::set(array(
		# Theme option
		'panel' => 'panel',
		# Theme Option > color options
		'section' => array(
		    'id'       => 'color-section',
		    'title'    => esc_html__( 'Color Options' ,'darkbiz' ),
		    'priority' => 5
		),
		'fields'  =>array(
			array(
				'id'      => 'primary-color',
				'label'   => esc_html__( 'Primary Color', 'darkbiz' ),
				'default' => '#FC7216',
				'type'    => 'darkbiz-color-picker',
			),
			array(
				'id'      => 'body-paragraph-color',
				'label'   => esc_html__( 'Body Text Color', 'darkbiz' ),
				'default' => '#5f5f5f',
				'type'    => 'darkbiz-color-picker',
			),
			array(
				'id'      => 'primary-menu-item-color',
				'label'   => esc_html__( 'Primary Menu Item color', 'darkbiz' ),
				'default' => '#737373',
				'type'    => 'darkbiz-color-picker',
			),
			array(
				'id'   => 'line-1',
				'type' => 'darkbiz-horizontal-line',
			),
			array(
				'id'      => 'link-color',
				'label'   => esc_html__( 'Link Color', 'darkbiz' ),
				'default' => '#145fa0',
				'type'    => 'darkbiz-color-picker',
			),
			array(
				'id'      => 'link-hover-color',
				'label'   => esc_html__( 'Link Hover Color', 'darkbiz' ),
				'default' => '#737373',
				'type'    => 'darkbiz-color-picker',
			),
			array(
				'id'   => 'line-2',
				'type' => 'darkbiz-horizontal-line',
			),
			array(
				'id'      => 'sb-widget-title-color',
				'label'   => esc_html__( 'Sidebar Widget Title Color', 'darkbiz' ),
				'default' => '#000000',
				'type'    => 'darkbiz-color-picker',
			),
			array(
				'id'      => 'sb-widget-content-color',
				'label'   => esc_html__( 'Sidebar Widget Content Color', 'darkbiz' ),
				'default' => '#282835',
				'type'    => 'darkbiz-color-picker',
			),
			array(
				'id'   => 'line-3',
				'type' => 'darkbiz-horizontal-line',
			),
			array(
				'id'      => 'footer-title-color',
				'label'   => esc_html__( 'Footer Widget Title Color', 'darkbiz' ),
				'default' => '#fff',
				'type'    => 'darkbiz-color-picker',
			),
			array(
				'id'      => 'footer-content-color',
				'label'   => esc_html__( 'Footer Widget Content Color', 'darkbiz' ),
				'default' => '#a8a8a8',
				'type'    => 'darkbiz-color-picker',
			),
			array(
				'id'   => 'line-4',
				'type' => 'darkbiz-horizontal-line',
			),
			array(
				'id'      => 'footer-top-background-color',
				'label'   => esc_html__( 'Footer Background Color', 'darkbiz' ),
				'default' => '#28292a',
				'type'    => 'darkbiz-color-picker',
			),
			array(
				'id'      => 'footer-copyright-background-color',
				'label'   => esc_html__( 'Footer Copyright Background Color', 'darkbiz' ),
				'default' => '#0c0808',
				'type'    => 'darkbiz-color-picker',
			),
			array(
				'id'      => 'footer-copyright-text-color',
				'label'   => esc_html__( 'Footer Copyright Text Color', 'darkbiz' ),
				'default' => '#ffffff',
				'type'    => 'darkbiz-color-picker',
			),
		),			
	));
}
add_action( 'init', 'darkbiz_color_options' );