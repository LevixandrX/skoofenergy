<?php
/**
 * Slider Widget.
 *
 * @since 1.0
 */
namespace RT_Easy_Builder;
use Elementor\Controls_Manager;

class Blog_Listing extends Widgets{

	protected $slug = 'rt-blog-listing';
	protected $directory_name = 'blog-listing';
	protected $title = 'Blog Listing';
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

		$categories = get_categories( array(
		    'orderby' => 'name',
		    'order'   => 'ASC'
		));

		$options = array();
		foreach( $categories as $category ){
			$options[ $category->term_id ] = $category->name;
		}

		$fields = array(
			'blog_listing_content_settings' => array(
				'label'  => esc_html__( 'General Settings', 'rise-builder' ),
				'fields' => array(
					'category' => array(
						'label'   => esc_html__( 'Select Category', 'rise-builder' ),
						'type'    => 'select',
						'default' => 1,
						'options' => $options
					),
					'per_row' => array(
						'label'   => esc_html__( 'Per Row', 'rise-builder' ),
						'type'    => 'number',
						'default' => 3,
						'min'     => 1,
						'max'     => 3
					),
					'per_page' => array(
						'label'   => esc_html__( 'Per Page', 'rise-builder' ),
						'type'    => 'number',
						'default' => 3,
						'min'     => 1,
						'max'     => 3
					),
					'show_title' => array(
						'label'   => esc_html__( 'Show Title', 'rise-builder' ),
						'type'    => 'switcher',
						'default' => 'yes'
					),
					'show_thumbnail' => array(
						'label'   => esc_html__( 'Show Thumbnail', 'rise-builder' ),
						'type'    => 'switcher',
						'default' => 'yes'
					),
					'show_category' => array(
						'label'   => esc_html__( 'Show Category', 'rise-builder' ),
						'type'    => 'switcher',
						'default' => 'yes'
					),
					'show_date' => array(
						'label'   => esc_html__( 'Show Date', 'rise-builder' ),
						'type'    => 'switcher',
						'default' => 'yes'
					),
					'show_excerpt' => array(
						'label'   => esc_html__( 'Show Excerpt', 'rise-builder' ),
						'type'    => 'switcher',
						'default' => 'yes'
					),
					'show_button' => array(
						'label'   => esc_html__( 'Show Button', 'rise-builder' ),
						'type'    => 'switcher',
						'default' => 'yes'
					),
					'button_text' => array(
						'label'   => esc_html__( 'Button Text', 'rise-builder' ),
						'type'    => 'text',
						'default' => 'Read More'
					),
				)
			),
		);

		return $fields;
	}

	public function get_style_fields(){
		$fields = array(
			'general_style' => array(
				'label' => esc_html__( 'General', 'rise-builder' ),
				'fields' => array(
					'padding' => array(
						'label' => esc_html__( 'Padding', 'rise-builder' ),
						'type'  => 'dimensions',
						'default' => array( 'top' => '15', 'right' => '15', 'bottom' => '15', 'left' => '15' ),
						'selectors' => array(
							'{{WRAPPER}} .rt-blog-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						)
					),
					'background' => array(
						'label'     => esc_html__( 'Background', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#f3f3f3',
						'selectors' => array(
							'{{WRAPPER}} .rt-blog-content-wrapper' => 'background-color: {{VALUE}};'
						)
					),
					'border-radius' => array(
						'label' => esc_html__( 'Border Radius', 'rise-builder' ),
						'type'  => 'dimensions',
						'default' => array( 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0' ),
						'selectors' => array(
							'{{WRAPPER}} .rt-blog-list-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						)
					)
				)
			),
			'title_style' => array(
				'label'  => esc_html__( 'Title', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-blog-title'
					),
					'title_color' => array(
						'type' => 'tabs',
						'fields' => array(
							'title_normal_color' => array(
								'label' => esc_html__( 'Normal', 'rise-builder' ),
								'fields' => array(
									'color' => array(
										'label'     => esc_html__( 'Color', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#333333',
										'selectors' => array(
											'{{WRAPPER}} .rt-blog-title a' => 'color: {{VALUE}};',
										)
									)
								)
							),
							'title_hover_color' => array(
								'label' => esc_html__( 'Hover', 'rise-builder' ),
								'fields' => array(
									'color' => array(
										'label'     => esc_html__( 'Color', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#333333',
										'selectors' => array(
											'{{WRAPPER}} .rt-blog-title a:hover' => 'color: {{VALUE}};',
										)
									)
								)
							)
						)
					),
					'margin' => array(
						'label'      => esc_html__( 'Margin', 'rise-builder' ),
						'type'       => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '20', 'right' => '0', 'bottom' => '20', 'left' => '0', 'isLinked' => false ),
						'selectors'  => array(
							'{{WRAPPER}} .rt-blog-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					)
				)
			),
			'meta_style' => array(
				'label'  => esc_html__( 'Meta', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-blog-category a, {{WRAPPER}} .rt-blog-date a',
					),
					'meta_color' => array(
						'type' => 'tabs',
						'fields' => array(
							'meta_normal_color' => array(
								'label' => esc_html__( 'Normal', 'rise-builder' ),
								'fields' => array(
									'color' => array(
										'label'     => esc_html__( 'Color', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#333333',
										'selectors' => array(
											'{{WRAPPER}} .rt-blog-category a' => 'color: {{VALUE}};',
											'{{WRAPPER}} .rt-blog-date a' => 'color: {{VALUE}};',
										)
									)
								)
							),
							'meta_hover_color' => array(
								'label' => esc_html__( 'Hover', 'rise-builder' ),
								'fields' => array(
									'color' => array(
										'label'     => esc_html__( 'Color', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#333333',
										'selectors' => array(
											'{{WRAPPER}} .rt-blog-category a:hover' => 'color: {{VALUE}};',
											'{{WRAPPER}} .rt-blog-date a:hover' => 'color: {{VALUE}};',
										)
									)
								)
							)
						)
					),
					'margin' => array(
						'label'      => esc_html__( 'Margin', 'rise-builder' ),
						'type'       => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0' ),
						'selectors'  => array(
							'{{WRAPPER}} .rt-blog-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					)
				)
			),
			'excerpt_style' => array(
				'label'  => esc_html__( 'Excerpt', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-blog-content',
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#333333',
						'selectors' => array(
							'{{WRAPPER}} .rt-blog-content' => 'color: {{VALUE}};',
						)
					),
					'margin' => array(
						'label'      => esc_html__( 'Margin', 'rise-builder' ),
						'type'       => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '20', 'right' => '0', 'bottom' => '20', 'left' => '0', 'isLinked' => false ),
						'selectors'  => array(
							'{{WRAPPER}} .rt-blog-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'selector' => '{{WRAPPER}} .rt-blog-link'
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
											'{{WRAPPER}} .rt-blog-link' => 'color: {{VALUE}};',
										)
									),
									'background' => array(
										'label'     => esc_html__( 'Background', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#372F2C',
										'selectors' => array(
											'{{WRAPPER}} .rt-blog-link' => 'background-color: {{VALUE}};'
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
											'{{WRAPPER}} .rt-blog-link:hover' => 'color: {{VALUE}};',
										)
									),
									'background' => array(
										'label'     => esc_html__( 'Background', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#372F2C',
										'selectors' => array(
											'{{WRAPPER}} .rt-blog-link:hover' => 'background-color: {{VALUE}};'
										)
									)
								)
							)
						)
					),
					'border-radius' => array(
						'label'     => esc_html__( 'Border Radius', 'rise-builder' ),
						'type'      => 'dimensions',
						'default'   => array( 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0' ),
						'selectors' => array(
							'{{WRAPPER}} .rt-blog-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						)
					),
					'padding' => array(
						'label'      => esc_html__( 'Padding', 'rise-builder' ),
						'type'       => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '10', 'right' => '15', 'bottom' => '10', 'left' => '15', 'isLinked' => false ),
						'selectors'  => array(
							'{{WRAPPER}} .rt-blog-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						)
					),
					'margin' => array(
						'label'      => esc_html__( 'Margin', 'rise-builder' ),
						'type'       => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => false ),
						'selectors'  => array(
							'{{WRAPPER}} .rt-blog-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						)
					)
				)
			)
		);

		return $fields;
	}
}