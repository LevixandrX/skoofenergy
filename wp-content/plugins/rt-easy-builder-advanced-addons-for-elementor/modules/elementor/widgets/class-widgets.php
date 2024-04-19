<?php
/**
 * Base class for widgets
 *
 * @since 1.0
 */
namespace RT_Easy_Builder;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;

abstract class Widgets extends Widget_Base{

	public function get_name() {
		return $this->slug;
	}

	public function get_title() {
		return $this->title;
	}

	public function get_icon() {
		return $this->icon;
	}

	public function get_categories() {
		$builder   = Builder::get_instance();
		$elementor = $builder->get_module( 'elementor' );
		return array( $elementor->widget_category[ 'slug' ] );
	}

	public function get_assets_uri( $file= '' ){
		return 'modules/elementor/widgets/' . $this->directory_name . '/' . trim( $file, '/' );
	}

	protected function register_controls(){

		do_action( 'rt_easy_builder_before_register_controls', $this );

		if( method_exists($this, 'get_content_fields' ) ){

			$fields = $this->get_content_fields();
			$fields = apply_filters( 'rt_easy_builder_content_fields', $fields, $this->slug );
			
			$this->add_tab_fields( $fields, 'content'  );
		}

		if( method_exists($this, 'get_style_fields' ) ){

			$fields = $this->get_style_fields();
			$fields = apply_filters( 'rt_easy_builder_style_fields', $fields, $this->slug );

			$this->add_tab_fields( $fields, 'style'  );
		}

		do_action( 'rt_easy_builder_after_register_controls', $this );
	}

	public function add_tab_fields( $args, $tab ){
		foreach( $args as $section_id => $section ){
			
			$this->start_controls_section( $section_id, array(
				'label' => $section[ 'label' ],
				'tab'   => $tab == 'content' ? Controls_Manager::TAB_CONTENT : Controls_Manager::TAB_STYLE,
			));

			if( 'content' == $tab ){
				$this->add_fields( $section[ 'fields' ] );
			}else{
				$this->add_fields( $section[ 'fields' ], $section_id );
			}
			
			$this->end_controls_section();
		}
	}

	public function render(){
		
		$builder = Builder::get_instance();
		$builder->require( "modules/elementor/widgets/{$this->directory_name}/template.php", array( 
			'settings' => $this->get_settings_for_display(),
			'base'     => $this
		));
	}

	public function add_fields( $fields, $section_id = false ){

		$builder = Builder::get_instance();

		$glue = '';
		if( $section_id ){
			$glue = explode( '_', $section_id );
			$glue = strtolower( trim( $glue[ 0 ] ) ) . '_';
		}

		foreach( $fields as $field_id => $field ){

			$type  = $builder->ucfirst( $field[ 'type' ] );	
			$class = $builder->get_class_name( 'Field_' . $type );

			if( !class_exists( $class ) ){
				$class = $builder->get_class_name( 'Field_Default' );
			}

			new $class(array(
				'id'    => $glue . $field_id,
				'field' => $field,
				'base'  => $this
			));
		}
	}

	public function render_anchor_tag( $button, $args ){
		
		if( !empty( $button[ 'url' ] ) ){

			$nofollow = $button[ 'nofollow' ] ? ' rel="nofollow"' : '';
			$attrs = array(
				'class'  => $args[ 'class' ],
				'href'   => $button[ 'url' ],
				'target' => $button[ 'is_external' ] ? '_blank' : ''
			);

			if( isset( $button[ 'custom_attributes' ] ) && '' != $button[ 'custom_attributes' ] ){
				$ca = explode( ',', $button[ 'custom_attributes' ] );
				foreach( $ca as $a ){
					$at = explode( '|', $a );
					if( isset( $at[0] ) ){
						$attrs[ $at[0] ] = isset( $at[ 1 ] ) ? $at[ 1 ] : '';
					}
				}
			}

			$name = $args[ 'name' ];
			$this->add_render_attribute( $name, $attrs );

			echo '<a ' . strip_tags( $this->get_render_attribute_string( $name ) )  . ' ' . $nofollow . '>'. esc_html( $args[ 'text' ] ). '</a>';
		}
	}

	public function make_category_arr( $_cat ){
		$cat = false;
		if( $_cat ){
			$cat = array(
				'name' => $_cat->name,
				'link' => get_category_link( $_cat->term_id )
			);
		}

		return $cat;
	}
}

