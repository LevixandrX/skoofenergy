<?php
namespace RT_Easy_Builder;
use \Elementor\Group_Control_Background;

class Field_Background{
	public function __construct( $params ){
		extract( $params );

		$field[ 'name' ] = $id;
		unset( $field[ 'type' ] );
		$base->add_group_control( Group_Control_Background::get_type(), $field );
	}
}