<?php
namespace RT_Easy_Builder;
use \Elementor\Controls_Manager;

class Field_Dimensions extends Builder{
	public function __construct( $params ){

		extract( $params );

		$field[ 'type' ] = Controls_Manager::DIMENSIONS ;
		$field[ 'devices' ] = array( 'desktop', 'tablet', 'mobile' );
		$base->add_responsive_control( $id, $field );
	}
}
