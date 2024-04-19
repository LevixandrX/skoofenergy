<?php
namespace RT_Easy_Builder;
use \Elementor\Controls_Manager;

class Field_Slider extends Builder{
	public function __construct( $params ){

		extract( $params );

		$field[ 'type' ] = Controls_Manager::SLIDER ;
		$field[ 'devices' ] = array( 'desktop', 'tablet', 'mobile' );
		$base->add_responsive_control( $id, $field );
	}
}
