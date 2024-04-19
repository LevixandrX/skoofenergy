<?php
/**
 * Pricing Table Widget.
 *
 * @since 1.3
 */
namespace RT_Easy_Builder;
use Elementor\Controls_Manager;

class Pricing_Table extends Widgets{

	protected $slug = 'rt-pricing-table';
	protected $directory_name = 'pricing-table';
	protected $title = 'Pricing Table';
	protected $icon = 'fa fa-newspaper-o';

	public function __construct( $data = [], $args = null ) {

		parent::__construct( $data, $args );

		add_action( 'wp_enqueue_scripts', [ $this, 'register_dependencies' ], 9999 );
	}

	public function register_dependencies(){
		
		$builder = Builder::get_instance();
		$script  = $builder->get_module( 'script-handler' );

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

	public function get_content_fields(){
		$fields = array(
			'pricing_table_content_settings' => array(
				'label'  => esc_html__( 'General Settings', 'rise-builder' ),
				'fields' => array(
					'name' => array(
						'label' => esc_html__( 'Name', 'rise-builder' ),
						'type'  => 'text',
						'placeholder' => 'Starter',
						'default' => ''
					),
					'icon' => array(
						'label' => esc_html__( 'Icon', 'rise-builder' ),
						'type'  => 'icon',
						'default' => 'fa fa-money'
					),
					'currency' => array(
						'label' => esc_html__( 'Currency', 'rise-builder' ),
						'type'  => 'text',
						'default' => '$'
					),
					'amount' => array(
						'label' => esc_html__( 'Amount', 'rise-builder' ),
						'type'  => 'text',
						'default' => '3'
					),
					'period' => array(
						'label' => esc_html__( 'Period', 'rise-builder' ),
						'type'  => 'text',
						'default' => 'month'
					),
					'button_text' => array(
						'label'   => esc_html__( 'Button Label', 'rise-builder' ),
						'type'    => 'text',
						'default' => 'Select'
					),
					'button_link' => array(
						'label'   => esc_html__( 'Button Link', 'rise-builder' ),
						'type'    => 'url',
						'default' => array( 'url' => '#' )
					)
				)
			),
			'pricing_table_features_settings' => array(
				'label' => esc_html__( 'Features', 'rise-builder' ),
				'fields' => array(
					'features' => array(
						'label'   => esc_html__( 'Add', 'rise-builder' ),
						'type'    => 'repeater',
						'title_field' => '{{{ label }}}',
						'fields' => array(
							'label' => array(
								'label' => esc_html__( 'Label', 'rise-builder' ),
								'type'  => 'text'
							)
						)
					),
				)
			)
		);

		return $fields;
	}

	public function get_style_fields(){
		$fields = array(
			'icon_style' => array(
				'label' => esc_html__( 'Icon', 'rise-builder' ),
				'fields' => array(
					'size' => array(
						'label' => esc_html__( 'Size', 'rise-builder' ),
						'type'  => 'slider',
						'size_units' => array( 'px' ),
						'range' => array(
							'px' => array(
								'min' => 10,
								'max' => 200
							)
						),
						'default' => array( 'unit' => 'px', 'size' => 50 ),
						'selectors' => array(
							'{{WRAPPER}} .rt-pricing-table-header > i' => 'font-size: {{SIZE}}{{UNIT}};'
						)
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#66e9ca',
						'selectors' => array(
							'{{WRAPPER}} .rt-pricing-table-header > i' => 'color: {{VALUE}};',
						)
					)
				)
			),
			'name_style' => array(
				'label' => esc_html__( 'Name', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-pricing-table-name'
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#66e9ca',
						'selectors' => array(
							'{{WRAPPER}} .rt-pricing-table-name' => 'color: {{VALUE}};',
						)
					)
				)
			),
			'period_style' => array(
				'label' => esc_html__( 'Period', 'rise-builder' ),
				'fields' => array(
					'font-family' => array(
						'label' => esc_html__( 'Font Family', 'rise-builder' ),
						'type' => 'font',
						'default' => '',
						'selectors' => array( 
							'{{WRAPPER}} .rt-pricing-table-price > h3, {{WRAPPER}} .rt-pricing-table-price > h3 sup, {{WRAPPER}} .rt-pricing-table-price > h3 sub' => 'font-family: "{{VALUE}}";' 
						)
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#686868',
						'selectors' => array(
							'{{WRAPPER}} .rt-pricing-table-price > h3, {{WRAPPER}} .rt-pricing-table-price > h3 sup, {{WRAPPER}} .rt-pricing-table-price > h3 sub' => 'color: {{VALUE}};',
						)
					)
				)
			),
			'feature_style' => array(
				'label' => esc_html__( 'Features', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-pricing-table-features ul li',
						'fields_options' => array(
							'font_weight' => array(
								'default' => 400
							),
							'font_family' => array(
								'default' => ''
							)
						)
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#717171',
						'selectors' => array(
							'{{WRAPPER}} .rt-pricing-table-features ul li' => 'color: {{VALUE}};',
						)
					)
				)
			),
			'button_style' => array(
				'label'  => esc_html__( 'Button', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-pricing-table-btn',
					),
					'color' => array(
						'type' => 'tabs',
						'fields' => array(
							'normal' => array(
								'label'  => esc_html__( 'Normal', 'rise-builder' ),
								'fields' => array(
									'color' => array(
										'label'     => esc_html__( 'Color', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#ffffff',
										'selectors' => array(
											'{{WRAPPER}} .rt-pricing-table-btn' => 'color: {{VALUE}};',
										)
									),
									'background' => array(
										'label'     => esc_html__( 'Background', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#66e9ca',
										'selectors' => array(
											'{{WRAPPER}} .rt-pricing-table-btn' => 'background-color: {{VALUE}};'
										)
									)
								)
							),
							'hover' => array(
								'label'  => esc_html__( 'Hover', 'rise-builder' ),
								'fields' => array(
									'color' => array(
										'label'     => esc_html__( 'Color', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#ffffff',
										'selectors' => array(
											'{{WRAPPER}} .rt-pricing-table-btn:hover' => 'color: {{VALUE}};',
										)
									),
									'background' => array(
										'label'     => esc_html__( 'Background', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#372F2C',
										'selectors' => array(
											'{{WRAPPER}} .rt-pricing-table-btn:hover' => 'background-color: {{VALUE}};'
										)
									)
								)
							)
						)
					),
					'border-radius' => array(
						'label'     => esc_html__( 'Border Radius', 'rise-builder' ),
						'type'      => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0' ),
						'selectors' => array(
							'{{WRAPPER}} .rt-pricing-table-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					),
					'padding' => array(
						'label'      => esc_html__( 'Padding', 'rise-builder' ),
						'type'       => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '15', 'right' => '30', 'bottom' => '15', 'left' => '30', 'isLinked' => false ),
						'selectors'  => array(
							'{{WRAPPER}} .rt-pricing-table-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					),
					'margin' => array(
						'label'     => esc_html__( 'Margin', 'rise-builder' ),
						'type'      => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => false ),
						'selectors' => array(
							'{{WRAPPER}} .rt-pricing-table-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					)
				)
			)
		);

		return $fields;
	}
}