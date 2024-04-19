<?php
namespace RT_Easy_Builder;
use \Elementor\Group_Control_Box_Shadow;

class Field_Box_Shadow{
	public function __construct( $params ){
		extract( $params );

		$field[ 'name' ] = $id;
		unset( $field[ 'type' ] );
		$base->add_group_control( Group_Control_Text_Shadow::get_type(), $field );
	}
}