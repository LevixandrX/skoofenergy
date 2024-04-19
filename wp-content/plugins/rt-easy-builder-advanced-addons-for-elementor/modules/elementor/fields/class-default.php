<?php
namespace RT_Easy_Builder;
use ReflectionClass;

class Field_Default extends Builder{
	public function __construct( $params ){

		extract( $params );

		$type = $this->ucfirst( $field[ 'type' ] );
		$class = new ReflectionClass( '\Elementor\Controls_Manager' );
		$field[ 'type' ] = $class->getConstant( strtoupper( $type ) );

		if( '' != $field[ 'type' ] ){
			$base->add_control( $id, $field );
		}
	}
}
