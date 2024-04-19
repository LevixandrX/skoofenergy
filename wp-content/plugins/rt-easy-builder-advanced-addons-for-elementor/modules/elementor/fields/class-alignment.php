<?php
namespace RT_Easy_Builder;
use \Elementor\Controls_Manager;

class Field_Alignment extends Builder{
	public function __construct( $params ){

		extract( $params );

		$field[ 'type' ] = Controls_Manager::CHOOSE;
		$field[ 'options' ] = array(
			'left' => array(
				'title' => esc_html__( 'Left', 'rise-builder' ),
				'icon'  => 'fa fa-align-left'
			),
			'center' => array(
				'title' => esc_html__( 'Center', 'rise-builder' ),
				'icon'  => 'fa fa-align-center'
			),
			'right' => array(
				'title' => esc_html__( 'Right', 'rise-builder' ),
				'icon'  => 'fa fa-align-right'
			)
		);

		$field[ 'devices' ] = array( 'desktop', 'tablet' );
		$field[ 'prefix_class' ] = 'content-align-%s';

		if( !isset( $field[ 'default' ] ) ){
			$field[ 'default' ] = 'left';
		}

		$base->add_responsive_control( $id, $field );
	}
}
