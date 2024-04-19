<?php
namespace RT_Easy_Builder;
use \Elementor\Group_Control_Image_Size;

class Field_Image_Size{
	public function __construct( $params ){
		extract( $params );

		$field[ 'name' ] = $id;
		unset( $field[ 'type' ] );
		$base->add_group_control( Group_Control_Image_Size::get_type(), $field );
	}
}