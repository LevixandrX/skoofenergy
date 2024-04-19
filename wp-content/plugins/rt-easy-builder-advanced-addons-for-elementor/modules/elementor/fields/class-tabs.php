<?php
namespace RT_Easy_Builder;
use \Elementor\Control_Tabs;

class Field_Tabs{
	public function __construct( $params ){
		extract( $params );

		//$id = button_color
		$base->start_controls_tabs( 'tabs_' . $id );
		
		$builder = Builder::get_instance();
		foreach( $field[ 'fields' ] as $tab => $field ){

			// $tab = normal, hover
			$base->start_controls_tab( 'tab_' . $id . '_' . $tab, array(
				'label' => $field[ 'label' ],
			));

			foreach( $field[ 'fields' ] as $f_id => $f ){

				$type  = $builder->ucfirst( $f[ 'type' ] );
				$class = $builder->get_class_name( 'Field_' . $type );
				
				if( !class_exists( $class ) ){
					$class = $builder->get_class_name( 'Field_Default' );
				}
				
				new $class( array(
					'id'    => $tab. '_' .$f_id,
					'field' => $f,
					'base'  => $base
				));
			}

			$base->end_controls_tab();

		}

		$base->end_controls_tabs();

	}
}