<?php
namespace RT_Easy_Builder;
use \Elementor\Controls_Manager;
use \Elementor\Repeater;

class Field_Repeater{

	public function __construct( $params ){ 

		extract( $params );
		$repeater = new Repeater();

		$builder = Builder::get_instance();
		foreach( $field[ 'fields' ] as $f_id => $f ){

			$type  = $builder->ucfirst( $f[ 'type' ] );
			$class = $builder->get_class_name( 'Field_' . $type );
			
			if( !class_exists( $class ) ){
				$class = $builder->get_class_name( 'Field_Default' );
			}
			
			new $class( array(
				'id'    => $f_id,
				'field' => $f,
				'base'  => $repeater
			));
		}

		$field[ 'fields' ] = $repeater->get_controls();
		$field[ 'type' ]   = Controls_Manager::REPEATER;
		$base->add_control( $id, $field );
	}
}