<?php
/**
* Register typography Options
*
* @return void
* @since 1.0.0
*
* @package Darkbiz WordPress theme
*/
function darkbiz_typography_options(){ 

    $message = esc_html__( 'The value is in px.', 'darkbiz' );
    Darkbiz_Customizer::set(array(
        # Theme option
        'panel' => array(
            'id'       => 'panel',
            'title'    => esc_html__( 'Darkbiz Options', 'darkbiz' ),
            'priority' => 10,
        ),
        # Theme Option > Header
        'section' => array(
            'id'    => 'typography',
            'title' => esc_html__( 'Typography','darkbiz' ),
            'priority' => 5
        ),
        # Theme Option > Header > settings
        'fields' => array(
            array(
                'id'          => 'site-info-font',
                'label'       => esc_html__( 'Site Identity Font Family', 'darkbiz' ),
                'description' => esc_html__( 'Font family for site title and tagline. Defaults to Poppins', 'darkbiz' ),
                'default'     => 'font-11',
                'type'        => 'select',
                'choices'     => Darkbiz_Theme::get_font_family(),
            ),
            array(
                'id'      => 'body-font',
                'label'   =>  esc_html__( 'Body Font Family.', 'darkbiz' ),
                'description' => esc_html__( 'Defaults to Poppins.', 'darkbiz' ),
                'default' => 'font-11',
                'type'    => 'select',
                'choices' => Darkbiz_Theme::get_font_family(),
            ),
            array(
                'id'          => 'heading-font',
                'label'       =>  esc_html__( 'Headings Font Family.', 'darkbiz' ),
                'description' =>  esc_html__( 'h1 to h6. Defaults to Poppins.', 'darkbiz' ),
                'default'     => 'font-11',
                'type'        => 'select',
                'choices'     => Darkbiz_Theme::get_font_family(),
            ),
            array(
                'id'          => 'body-font-size',
                'label'       => esc_html__( 'Body Font Size.', 'darkbiz' ),
                'description' => $message . ' ' . esc_html__( 'Defaults to 15px.', 'darkbiz' ),
                'type'        => 'darkbiz-slider',
                'default' => array(
                    'desktop' => 15,
                    'tablet'  => 15,
                    'mobile'  => 15,
                ),
                'input_attrs' =>  array(
                    'min'   => 1,
                    'max'   => 40,
                    'step'  => 1,
                ),
            ),
            array(
                'id'          => 'post-title-size',
                'label'       => esc_html__( 'Post Title Font Size', 'darkbiz' ),
                'description' => $message . ' ' . esc_html__( 'Defaults to 21px.' , 'darkbiz' ),
                'default' => array(
                    'desktop' => 21,
                    'tablet'  => 21,
                    'mobile'  => 21,
                ),
                'input_attrs' =>  array(
                    'min'   => 1,
                    'max'   => 60,
                    'step'  => 1,
                ),
                'type' => 'darkbiz-slider',
            ),
            array(
                'id'          => 'primary-menu-font-size',
                'label'       => esc_html__( 'Primary Menu Font Size', 'darkbiz' ),
                'description' => $message . ' ' . esc_html( 'Defaults to 15px.', 'darkbiz' ),
                'type'        => 'darkbiz-slider',
                'default' => array(
                    'desktop' => 15,
                    'tablet'  => 15,
                    'mobile'  => 15,
                ),
                'input_attrs' =>  array(
                    'min'   => 1,
                    'max'   => 40,
                    'step'  => 1,
                ),
            ),
            array(
                'id'          => 'widget-title-font-size',
                'label'       => esc_html__( 'Widget Title Font Size', 'darkbiz' ),
                'description' => $message . ' ' . esc_html( 'Defaults to 18px.', 'darkbiz' ),
                'type'        => 'darkbiz-slider',
                'default' => array(
                    'desktop' => 18,
                    'tablet'  => 18,
                    'mobile'  => 18,
                ),
                'input_attrs' =>  array(
                    'min'   => 1,
                    'max'   => 60,
                    'step'  => 1,
                ),
            ),
            array(
                'id'          => 'widget-content-font-size',
                'label'       => esc_html__( 'Widget Content Font Size', 'darkbiz' ),
                'description' => $message . ' ' . esc_html( 'Defaults to 16px.', 'darkbiz' ),
                'type'        => 'darkbiz-slider',
                'default' => array(
                    'desktop' => 16,
                    'tablet'  => 16,
                    'mobile'  => 16,
                ),
                'input_attrs' =>  array(
                    'min'   => 1,
                    'max'   => 40,
                    'step'  => 1,
                ),
            ),
        )
    ));
}
add_action( 'init', 'darkbiz_typography_options' );