<?php
/**
 * team list Widget.
 *
 * @since 1.0
 */
namespace RT_Easy_Builder;
use Elementor\Controls_Manager;

class Profile_Card extends Widgets{

	protected $slug  = 'rt-profile-card';
	protected $directory_name  = 'profile-card';
	protected $title = 'Profile Card';
	protected $icon  = 'fa fa-address-card';

	public function __construct($data = [], $args = null) {

		parent::__construct($data, $args);
		add_action( 'wp_enqueue_scripts', [ $this, 'register_dependencies' ], 9999 );
	}

	public function register_dependencies(){
		
		$builder = Builder::get_instance();
		$script = $builder->get_module( 'script-handler' );

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
			'team_list_content_setting' => array(
				'label'  => esc_html__( 'General Settings', 'rise-builder' ),
				'fields' => array(
					'team_name' => array(
						'label'   => esc_html__( 'Name', 'rise-builder' ),
						'type'    => 'text',
						'default' => 'John Doe'
					),
					'team_image' => array(
						'label' => esc_html__( 'Image', 'rise-builder' ),
						'type'  => 'media'
					),
					'team_image_height' => array(
						'label' => esc_html__( 'Image Height', 'rise-builder' ),
						'type'  => 'slider',
						'size_units' => array( 'px' ),
						'range' => array(
							'px' => array(
								'min' => 0,
								'max' => 1000
							)
						),
						'default' => array( 'unit' => 'px' ),
						'selectors' => array(
							'{{WRAPPER}} .rt-team-image img' => 'height: {{SIZE}}{{UNIT}};'
						),
					),
					'team_image_property' => array(
						'label' => esc_html__( 'Image Property', 'rise-builder' ),
						'type'  => 'select',
						'options' => array(
							'initial'    => esc_html__( 'Initial', 'rise-builder' ),
							'inherit'    => esc_html__( 'Inherit', 'rise-builder' ),
							'cover'      => esc_html__( 'Cover', 'rise-builder' ),
							'contain'    => esc_html__( 'Contain', 'rise-builder' )
						),
						'default' => 'cover',
						'selectors' => array(
							'{{WRAPPER}} .rt-team-image img' => 'object-fit: {{VALUE}};'
						)
					),
					'team_image_position' => array(
						'label' => esc_html__( 'Image Position', 'rise-builder' ),
						'type'  => 'select',
						'options' => array(
							'top'    => esc_html__( 'Top', 'rise-builder' ),
							'right'  => esc_html__( 'Right', 'rise-builder' ),
							'bottom' => esc_html__( 'Bottom', 'rise-builder' ),
							'left'   => esc_html__( 'Left', 'rise-builder' ),
							'center' => esc_html__( 'Center', 'rise-builder' )
						),
						'default' => 'top',
						'selectors' => array(
							'{{WRAPPER}} .rt-team-image img' => 'object-position: {{VALUE}};'
						)
					),
					'team_designation' => array(
						'label'   => esc_html__( 'Designation', 'rise-builder' ),
						'type'    => 'text',
						'default' => 'General Manager'
					),
					'team_description' => array(
						'label'   => esc_html__( 'Description', 'rise-builder' ),
						'type'    => 'textarea',
						'default' => 'Necessitatibus aliquid lobortis venenatis nisi mollis tristique officiis tempora asperiores perferendis mollitia fugit tristique purus.'
					),
					'team_social' => array(
						'label'   => esc_html__( 'Social', 'rise-builder' ),
						'type'    => 'repeater',
						'fields'  => array(
							'team_social_icon' => array(
								'label' => esc_html__( 'Choose Icon', 'rise-builder' ),
								'type'  => 'icon',
								'default' => 'fa fa-facebook-official'
							),
							'team_social_link' => array(
								'label' => esc_html__( 'Link', 'rise-builder' ),
								'type'  => 'url',
								'default' => array(
									'url' => '#'
								)
							)
						)
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
					'layout' => array(
						'label' => esc_html__( 'Layout', 'rise-builder' ),
						'type'  => 'select',
						'options' => [
							'layout-1' => esc_html__( 'Layout 1', 'rise-builder' ),
							'layout-2' => esc_html__( 'Layout 2', 'rise-builder' )
						],
						'default' => 'layout-1'
					),
					'alignment' => array(
						'label'   => esc_html__( 'Alignment', 'rise-builder' ),
						'type'    => 'alignment',
						'default' => 'center'
					),
					'padding' => array(
						'label' => esc_html__( 'Padding', 'rise-builder' ),
						'type'  => 'dimensions',
						'default' => array( 'top' => '15', 'right' => '15', 'bottom' => '15', 'left' => '15' ),
						'selectors' => array(
							'{{WRAPPER}} .rt-team-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						)
					),
					'background' => array(
						'label'     => esc_html__( 'Background', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#eeeeee',
						'selectors' => array(
							'{{WRAPPER}} .rt-team-box-wrapper' => 'background-color: {{VALUE}};'
						)
					),
					'border_radius' => array(
						'label'      => esc_html__( 'Border Radius', 'rise-builder' ),
						'type'       => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0' ),
						'selectors'  => array(
							'{{WRAPPER}} .rt-team-box-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
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
						'selector' => '{{WRAPPER}} .rt-team-name'
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#333333',
						'selectors' => array(
							'{{WRAPPER}} .rt-team-name' => 'color: {{VALUE}};',
						)
					),
					'margin' => array(
						'label'     => esc_html__( 'Margin', 'rise-builder' ),
						'type'      => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '10', 'right' => '0', 'bottom' => '10', 'left' => '0', 'isLinked' => false ),
						'selectors' => array(
							'{{WRAPPER}} .rt-team-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					)
				)
			),
			'designation_style' => array(
				'label'  => esc_html__( 'Designation', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-team-designation',
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#333333',
						'selectors' => array(
							'{{WRAPPER}} .rt-team-designation' => 'color: {{VALUE}};',
						)
					),
					'margin' => array(
						'label'     => esc_html__( 'Margin', 'rise-builder' ),
						'type'      => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '0', 'right' => '0', 'bottom' => '10', 'left' => '0', 'isLinked' => false ),
						'selectors' => array(
							'{{WRAPPER}} .rt-team-designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					)
				)
			),
			'description_style' => array(
				'label'  => esc_html__( 'Description', 'rise-builder' ),
				'fields' => array(
					'typography' => array(
						'label'    => esc_html__( 'Typography', 'rise-builder' ),
						'type'     => 'typography',
						'selector' => '{{WRAPPER}} .rt-team-description',
					),
					'color' => array(
						'label'     => esc_html__( 'Color', 'rise-builder' ),
						'type'      => 'color',
						'default'   => '#333333',
						'selectors' => array(
							'{{WRAPPER}} .rt-team-description' => 'color: {{VALUE}};',
						)
					),
					'margin' => array(
						'label'     => esc_html__( 'Margin', 'rise-builder' ),
						'type'      => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '0', 'right' => '0', 'bottom' => '15', 'left' => '0', 'isLinked' => false ),
						'selectors' => array(
							'{{WRAPPER}} .rt-team-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					)
				)
			),
			'social_icon' => array(
				'label' => esc_html__( 'Social', 'rise-builder' ),
				'fields' => array(
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
											'{{WRAPPER}} .rt-team-social-links a' => 'color: {{VALUE}};',
										)
									),
									'background' => array(
										'label'     => esc_html__( 'Background', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#372F2C',
										'selectors' => array(
											'{{WRAPPER}} .rt-team-social-links a' => 'background-color: {{VALUE}};'
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
											'{{WRAPPER}} .rt-team-social-links a:hover' => 'color: {{VALUE}};',
										)
									),
									'background' => array(
										'label'     => esc_html__( 'Background', 'rise-builder' ),
										'type'      => 'color',
										'default'   => '#372F2C',
										'selectors' => array(
											'{{WRAPPER}} .rt-team-social-links a:hover' => 'background-color: {{VALUE}};'
										)
									)
								)
							)
						)
					),
					'border_radius' => array(
						'label'      => esc_html__( 'Border Radius', 'rise-builder' ),
						'type'       => 'dimensions',
						'size_units' => array( 'px' ),
						'default'    => array( 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0' ),
						'selectors'  => array(
							'{{WRAPPER}} .rt-team-social-links a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						)
					),
					'size' => array(
						'label'      => esc_html__( 'Size', 'rise-builder' ),
						'type'       => 'slider',
						'size_units' => array( 'px' ),
						'default' => array( 'unit' => 'px', 'size' => 30 ),
						'selectors'  => array(
							'{{WRAPPER}} .rt-team-social-links a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						)
					),
					'icon_size' => array(
						'label'      => esc_html__( 'Icon Size', 'rise-builder' ),
						'type'       => 'slider',
						'size_units' => array( 'px' ),
						'default' => array( 'unit' => 'px', 'size' => 20 ),
						'selectors'  => array(
							'{{WRAPPER}} .rt-team-social-links a' => 'font-size: {{SIZE}}{{UNIT}};',
						)
					)
				)
 			)
		);

		return $fields;
	}

	public function _content_template(){
		?>
		<div class="rt-team-box-wrapper {{{ settings.general_layout }}}">
			<div class="rt-team-box-inner">
				<# if ( settings.team_image ) { #>
					<div class="rt-team-image">
						<img src="{{{ settings.team_image.url }}}" alt="">
					</div>
				<# } #>
				<div class="rt-team-content">
					<h3 class="rt-team-name">{{{settings.team_name}}}</h3>
					<h4 class="rt-team-designation">{{{settings.team_designation}}}</h4>
					<p class="rt-team-description">{{{settings.team_description}}}</p>
					<# if ( settings.team_social ) { #>
						<ul class="rt-team-social-links">
							<# _.each( settings.team_social, function( item ) { #>
								<li>
									<a href="{{{item.team_social_link.url}}}">
										<i class="{{{item.team_social_icon}}}"></i>
									</a>
								</li>
							<# }); #>
						</ul>
					<# } #>
				</div>
			</div>
		</div>
		<?php
	}
}