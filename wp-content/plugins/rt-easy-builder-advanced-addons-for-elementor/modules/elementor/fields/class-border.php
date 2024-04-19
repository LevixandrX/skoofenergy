<?php
namespace RT_Easy_Builder;
use \Elementor\Group_Control_Border;

class Field_Border{
	public function __construct( $params ){
		extract( $params );

		$field[ 'name' ] = $id;
		unset( $field[ 'type' ] );
		$base->add_group_control( Group_Control_Border::get_type(), $field );
	}
}