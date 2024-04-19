<?php
/**
 * RT Featured Slider Widget.
 *
 * @since 1.0
 */
namespace RT_Easy_Builder;
use Elementor\Controls_Manager;
class Slider extends Widgets{

	protected $slug  = 'rt-featured-slider';
	protected $directory_name = 'slider';
	protected $title = 'Featured Slider';
	protected $icon  = 'fa fa-image';

	public function __construct($data = [], $args = null) {

		parent::__construct($data, $args);
		add_action( 'wp_enqueue_scripts', [ $this, 'register_dependencies' ], 9999 );
	}

	public function register_dependencies(){
		
		$builder = Builder::get_instance();
		$script = $builder->get_module( 'script-handler' );

		// Register scripts
		$script->register(array(
			'handler' => 'slick',
			'file'    => $this->get_assets_uri( 'assets/slick/slick.min.js' )
		));

		$script->register(array(
			'handler'    => $this->slug,
			'file'       => $this->get_assets_uri( 'assets/script.js' ),
			'dependency' => array( 'elementor-frontend', 'jquery', 'slick' )
		));

		// Register styles
		$script->register(array(
			'handler' => 'slick',
			'file'    => $this->get_assets_uri( 'assets/slick/slick.css' )
		));

		$script->register(array(
			'handler' => $this->slug,
			'file'    => $this->get_assets_uri( 'assets/style.css' )
		));
	}

	public function get_script_depends() {
		return array(
			'slick',
			$this->slug
		);
	}

	public function get_style_depends() {
		return array(
			'slick',
			$this->slug
		);
	}

	public function get_content_fields(){
		$fields = array(
			'featured_slider_content_settings' => array(
				'label' => esc_html__( 'Slides', 'rise-builder' ),
				'fields' => array(
					'slides' => array(
						'title_field' => '{{{ title }}}',
						'type' => 'repeater',
						'fields' => array(
							'title' => array(
								'label'   => esc_html__( 'Title', 'rise-builder' ),
								'type'    => 'text',
								'default' => 'RT Slider'
							),
							'background' => array(
								'label' => esc_html__( 'Background', 'rise-builder' ),
								'type'  => 'background',
								'types' => [ 'classic', 'gradient' ],
								'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
								'fields_options' => array(
									'size' => array(
										'default' => 'cover'
									),
									'repeat' => array(
										'default' => 'no-repeat'
									)
								)
							),
							'content' => array(
								'label' => esc_html__( 'Content', 'rise-builder' ),
								'type'  => 'textarea',
								'default' => 'Interdum, diamlorem ratione quam doloribus rutrum pretium aute doloremque voluptatibus unde dignissim voluptas minim rutrum.'
							),
							'button_text_1' => array(
								'label'   => esc_html__( 'Button Text', 'rise-builder' ),
								'type'    => 'text',
								'default' => 'More'
							),
							'button_link_1' => array(
								'label'   => esc_html__( 'Button Link', 'rise-builder' ),
								'type'    => 'url',
								'default' => array(
									'url' => '#'
								)
							)
 						)
					)
				)
			),
			'featured_slider_option' => array(
				'label' => esc_html__( 'Slider Options', 'rise-builder' ),
				'fields' => array(
					'show_dots' => array(
						'label'   => esc_html__( 'Show Dots', 'rise-builder' ),
						'type'    => 'switcher',
						'default' => 'yes'
					),
					'show_arrows' => array(
						'label'   => esc_html__( 'Show Arrows', 'rise-builder' ),
						'type'    => 'switcher',
						'default' => 'yes'
					),
					'infinite' => array(
						'label'   => esc_html__( 'Infinite', 'rise-builder' ),
						'type'    => 'switcher',
						'default' => 'yes'
					),
					'slides_to_show' => array(
						'label'   => esc_html__( 'Slides to show', 'rise-builder' ),
						'type'    => 'number',
						'default' => 1,
						'max'     => 2,
						'min'     => 1
					)
				)
			)
		);

		return $fields;
	}

	public function get_style_fields(){
		$fields = array(
			'slide_style' => array(
				'label'  => esc_html__( 'General', 'rise-builder' ),
				'fields' => array(
					'height' => array(
						'label' => esc_html__( 'Height', 'rise-builder' ),
						'type'  => 'slider',
						'size_units' => array( 'px', 'vh' ),
						'range' => array(
							'px' => array(
								'min' => 0,
								'max' => 1000
							),
							'vh' => array(
								'min' => 0,
								'max' => 100,
							),
						),
						'default' => array( 'unit' => 'vh', 'size' => 80 ),
						'selectors' => array(
							'{{WRAPPER}} .rt-featured-slider-item-wrapper' => 'height: {{SIZE}}{{UNIT}};'
						),
						'render_type' => 'template'
					),
					'width' => array(
						'label' => esc_html__( 'Width', 'rise-builder' ),
						'type'  => 'slider',
						'size_units' => array( 'px', 'vw' ),
						'range' => array(
							'px' => array(
								'min' => 0,
								'max' => 2000
							),
							'vw' => array(
								'min' => 0,
								'max' => 100,
							),
						),
						'default' => array( 'unit' => 'px', 'size' => 1140 ),
						'selectors' => array(
							'{{WRAPPER}} .rt-featured-slider-item' => 'max-width: {{SIZE}}{{UNIT}};'
						),
						'render_type' => 'template'
					),
					'gap' => array(
						'label' => esc_html__( 'Gap Between Slides', 'rise-builder' ),
						'description' => esc_html__( 'Works only if slides to show is greater than 1.', 'rise-builder' ),
						'type'  => 'slider',
						'size_units' => array( 'px' ),
						'default' => array( 'unit' => 'px', 'size' => 0 ),
						'selectors' => array(
							'{{WRAPPER}} .rt-featured-slider-item-wrapper' => 'margin: 0 {{SIZE}}{{UNIT}};',
							'{{WRAPPER}} .rt-featured-slider' => 'margin: 0 -{{SIZE}}{{UNIT}};',

						),
						'render_type' => 'template'
					),
					'alignment' => array(
						'label'   => esc_html__( 'Alignment', 'rise-builder' ),
						'type'    => 'alignment',
						'default' => 'center'
					)
				)
			),
			'title_style' => array(
				'label'  => esc_html__( 'Title', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-featured-slider-title',
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#ffffff',
						'selectors' => array(
							'{{WRAPPER}} .rt-featured-slider-title' => 'color: {{VALUE}};',
						)
					),
					'margin' => array(
						'label'     => esc_html__( 'Margin', 'rise-builder' ),
						'type'      => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '0', 'right' => '0', 'bottom' => '20', 'left' => '0', 'isLinked' => false ),
						'selectors' => array(
							'{{WRAPPER}} .rt-featured-slider-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					)
				)
			),
			'content_style' => array(
				'label'  => esc_html__( 'Content', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-featured-slider-content',
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#ffffff',
						'selectors' => array(
							'{{WRAPPER}} .rt-featured-slider-content *, {{WRAPPER}} .rt-featured-slider-content' => 'color: {{VALUE}};',
						)
					),
					'margin' => array(
						'label'     => esc_html__( 'Margin', 'rise-builder' ),
						'type'      => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '0', 'right' => '0', 'bottom' => '35', 'left' => '0', 'isLinked' => false ),
						'selectors' => array(
							'{{WRAPPER}} .rt-featured-slider-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'selector' => '{{WRAPPER}} .rt-featured-slider-link',
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
											'{{WRAPPER}} .rt-featured-slider-link' => 'color: {{VALUE}};',
										)
									),
									'background' => array(
										'label'     => esc_html__( 'Background', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#372F2C',
										'selectors' => array(
											'{{WRAPPER}} .rt-featured-slider-link' => 'background-color: {{VALUE}};',
											'{{WRAPPER}} .rt-featured-slider ul.slick-dots li.slick-active button' => 'background-color: {{VALUE}};',
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
											'{{WRAPPER}} .rt-featured-slider-link:hover' => 'color: {{VALUE}};',
										)
									),
									'background' => array(
										'label'     => esc_html__( 'Background', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#372F2C',
										'selectors' => array(
											'{{WRAPPER}} .rt-featured-slider-link:hover' => 'background-color: {{VALUE}};'
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
							'{{WRAPPER}} .rt-featured-slider-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					),
					'padding' => array(
						'label'      => __( 'Padding', 'rise-builder' ),
						'type'       => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '15', 'right' => '30', 'bottom' => '15', 'left' => '30', 'isLinked' => false ),
						'selectors'  => array(
							'{{WRAPPER}} .rt-featured-slider-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					),
					'margin' => array(
						'label'     => esc_html__( 'Margin', 'rise-builder' ),
						'type'      => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => false ),
						'selectors' => array(
							'{{WRAPPER}} .rt-featured-slider-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					)
				)
			)
		);

		return $fields;
	}

}