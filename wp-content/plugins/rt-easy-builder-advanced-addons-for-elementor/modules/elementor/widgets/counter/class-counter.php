<?php
/**
 * Counter Widget.
 *
 * @since 1.2
 */
namespace RT_Easy_Builder;
use Elementor\Controls_Manager;
class Counter extends Widgets{

	protected $slug = 'rt-counter';
	protected $directory_name = 'counter';
	protected $title = 'Counter';
	protected $icon  = 'fa fa-sort-numeric-asc';

	public function __construct($data = [], $args = null) {

		parent::__construct($data, $args);
		
		add_action( 'wp_enqueue_scripts', [ $this, 'register_dependencies' ], 9999 );
	}

	public function register_dependencies(){
		
		$builder = Builder::get_instance();
		$script = $builder->get_module( 'script-handler' );
		
		// Register scripts
		$script->register(array(
			'handler'    => $this->slug,
			'file'       => $this->get_assets_uri( 'assets/script.js' ),
			'dependency' => array( 'elementor-frontend', 'jquery' )
		));

		// Register styles
		$script->register(array(
			'handler' => $this->slug,
			'file'    => $this->get_assets_uri( 'assets/style.css' )
		));
	}

	public function get_style_depends() {
		return array(
			$this->slug
		);
	}

	public function get_script_depends() {
		return array(
			$this->slug
		);
	}

	public function get_content_fields(){
		$fields = array(
			'counter_content_settings' => array(
				'label' => esc_html__( 'Counter', 'rise-builder' ),
				'fields' => array(
					'label' => array(
						'label'   => esc_html__( 'Label', 'rise-builder' ),
						'type'    => 'text',
						'default' => 'Happy Users'
					),
					'number' => array(
						'label'   => esc_html__( 'Number', 'rise-builder' ) ,
						'type'    => 'number',
						'default' => 999
					),
					'icon' => array(
						'label' => esc_html__( 'Icon', 'rise-builder' ),
						'type'  => 'icon',
						'default' => 'fa fa-user'
					),
					'append_plus' => array(
						'label'   => esc_html__( 'Append Plus Sign', 'rise-builder' ),
						'type'    => 'switcher',
						'default' => 'yes'
					),
					'duration' => array(
						'label'   => esc_html__( 'Duration', 'rise-builder' ),
						'type'    => 'number',
						'default' => 3
					)
				)
			)
		);

		return $fields;
	}

	public function get_style_fields(){
		$fields = array(
			'counter_style' => array(
				'label'  => esc_html__( 'Icon', 'rise-builder' ),
				'fields' => array(
					'size' => array(
						'label' => esc_html__( 'Size', 'rise-builder' ),
						'type'  => 'slider',
						'size_units' => array( 'px' ),
						'range' => array(
							'px' => array(
								'min' => 1,
								'max' => 1000
							)
						),
						'default' => array( 'unit' => 'px', 'size' => 100 ),
						'selectors' => array(
							'{{WRAPPER}} .rt-counter-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};'
						)
					),
					'icon_size' => array(
						'label' => esc_html__( 'Font Size', 'rise-builder' ),
						'type'  => 'slider',
						'size_units' => array( 'px' ),
						'range' => array(
							'px' => array(
								'min' => 1,
								'max' => 1000
							)
						),
						'default' => array( 'unit' => 'px', 'size' => 50 ),
						'selectors' => array(
							'{{WRAPPER}} .rt-counter-icon .fa' => 'font-size: {{SIZE}}{{UNIT}};'
						)
					),
					'bg_color' => array(
						'label' => esc_html__( 'Background Color', 'rise-builder' ),
						'type'  => 'color',
						'default' => '#000000',
						'selectors' => array(
							'{{WRAPPER}} .rt-counter-icon' => 'background-color: {{VALUE}};',
						)
					),
					'color' => array(
						'label' => esc_html__( 'Color', 'rise-builder' ),
						'type'  => 'color',
						'default' => '#ffffff',
						'selectors' => array(
							'{{WRAPPER}} .rt-counter-icon .fa' => 'color: {{VALUE}};',
						)
					) 
				)
			),
			'number_style' => array(
				'label' => esc_html__( 'Number', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-counter-number'
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#000000',
						'selectors' => array(
							'{{WRAPPER}} .rt-counter-number' => 'color: {{VALUE}};'
						)
					)
				)
			),
			'label_style' => array(
				'label' => esc_html__( 'Label', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-counter-label'
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#000000',
						'selectors' => array(
							'{{WRAPPER}} .rt-counter-label' => 'color: {{VALUE}};'
						)
					)
				)
			)
		);

		return $fields;
	}

}