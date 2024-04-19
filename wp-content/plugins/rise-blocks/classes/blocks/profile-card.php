<?php

/**
 * Render Profile Card block
 *
 * @since 1.0.0
 * @package Rise Block
 */
if (!class_exists('Rise_Blocks_Profile_Card')) {

	class Rise_Blocks_Profile_Card extends Rise_Blocks_Base
	{

		/**
		 * Slug of the block.
		 *
		 * @access protected
		 * @since 1.0.0
		 * @var string
		 */
		protected $slug = 'profile-card';

		/**
		 * Whether the block is insertable or not.
		 *
		 * Setting this variable to false will bypass in plugins landing page.
		 * @access public
		 * @since 1.0.0
		 * @var string
		 */
		public $inserter = false;

		/**
		 * Title of this block.
		 *
		 * @access protected
		 * @since 1.0.0
		 * @var string
		 */
		protected $title = '';

		/**
		 * Description of this block.
		 *
		 * @access protected
		 * @since 1.0.0
		 * @var string
		 */
		protected $description = '';

		/**
		 * SVG Icon for this block.
		 *
		 * @access protected
		 * @since 1.0.0
		 * @var string
		 */
		protected $icon = '<svg width="24" height="24" role="img" aria-hidden="true" focusable="false"><path fill="none" stroke="#fff" stroke-width="1.34" stroke-miterlimit="10" d="M19 17.9H1c-0.2 0-0.3-0.1-0.3-0.3V6.1C0.7 6 0.8 5.8 1 5.8H19c0.2 0 0.3 0.1 0.3 0.3v11.5C19.3 17.8 19.2 17.9 19 17.9z"></path><circle fill="#FFFFFF" stroke="#fff" stroke-width="1.34" stroke-miterlimit="10" cx="6.6" cy="5.6" r="3.6"></circle></svg>';

		/**
		 * link to the demo of this block.
		 *
		 * @access protected
		 * @since 1.0.0
		 * @var string
		 */
		protected $demo_link = 'profile-card';

		/**
		 * To store Array of this blocks that user adds
		 *
		 * @access protected
		 * @since 1.0.0
		 * @var array
		 */
		protected $blocks = array();

		/**
		 * The object instance.
		 *
		 * @static
		 * @access protected
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance;

		/**
		 * Constructor Function.
		 *
		 * @static
		 * @access protected
		 * @since 1.0.0
		 * @var object
		 */
		public function __construct()
		{
			$this->title       = esc_html__('Profile Card', 'rise-blocks');
			$this->description = esc_html__('Add this block to share your energetic team members. You can add their photo, name, description and social profiles.', 'rise-blocks');
		}

		/**
		 * Gets an instance of this object.
		 * Prevents duplicate instances which avoid artefacts and improves performance.
		 *
		 * @static
		 * @access public
		 * @since 1.0.0
		 * @return object
		 */
		public static function get_instance()
		{
			if (!self::$instance) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Generate & Print Frontend Styles
		 * Called in wp_head hook
		 * @access public
		 * @since 1.0.0
		 * @return null
		 */
		public function prepare_scripts_styles()
		{

			$this->get_blocks();
			foreach ($this->blocks as $block) {

				$attrs = $block['attrs'];

				/* Spacing */
				$name_padding = self::get_dimension_props('padding', $attrs['namePadding']);
				$designation_padding = self::get_dimension_props('padding', $attrs['designationPadding']);

				/* Typography */
				$name_typo = self::get_typography_props($attrs['nameTypography']);
				$designation_typo = self::get_typography_props($attrs['designationTypography']);
				$content_typo = self::get_typography_props($attrs['contentTypography']);
				$socialMedia_border_radius = self::get_dimension_props('border-radius', $attrs['socialMediaBorderRadius']);

				foreach (self::$devices as $device) {
					$css = array(
						array(
							'selector' => self::add_prefix('.%prefix-profile-card .%prefix-description-wrapper .%prefix-profile-card-title > *'),
							'props'    => array_merge($name_padding[$device], $name_typo[$device])
						),
						array(
							'selector' => self::add_prefix('.%prefix-profile-card .%prefix-description-wrapper .%prefix-profile-card-designation'),
							'props'    => array_merge($designation_padding[$device], $designation_typo[$device])
						),
						array(
							'selector' => self::add_prefix('.%prefix-profile-card .%prefix-description-wrapper .%prefix-profile-card-description'),
							'props'    => $content_typo[$device]
						)
					);

					self::add_styles(array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device);
				};


				$dynamic_css = array(
					array(
						'selector' => self::add_prefix('.%prefix-profile-card .%prefix-description-wrapper .%prefix-profile-card-title > *'),
						'props' => array(
							'color' => 'nameColor'
						)
					),
					array(
						'selector' => self::add_prefix('.%prefix-profile-card .%prefix-profile-card-image'),
						'props' => array(
							'background-image' => array(
								'value' => 'url(' . esc_url($attrs['image']['url']) . ')'
							),
							'background-position' => 'backgroundPosition'
						)
					),
					array(
						'selector' => '',
						'props' => array(
							'background-color' => 'backgroundColor'
						)
					),
					array(
						'selector' => self::add_prefix('.%prefix-profile-card .%prefix-description-wrapper .%prefix-profile-card-designation > span'),
						'props' => array(
							'border-color' => 'designationColor'
						)
					),
					array(
						'selector' => self::add_prefix('.%prefix-profile-card .%prefix-description-wrapper .%prefix-profile-card-designation'),
						'props' => array(
							'color' => 'designationColor'
						)
					),
					array(
						'selector' => self::add_prefix('.%prefix-profile-card .%prefix-description-wrapper .%prefix-profile-card-description > *'),
						'props' => array(
							'color' => 'contentColor'
						)
					),
					array(
						'selector' => self::add_prefix('.%prefix-profile-card .%prefix-social-media a'),
						'props'    => array_merge(
							array(
								'color' => 'socialMediaColor',
								'border' => array(
									'value' => '1px solid' . $attrs['socialMediaColor']
								)
							),
							$socialMedia_border_radius['desktop']
						)
					),
					array(
						'selector' => self::add_prefix('.%prefix-profile-card .%prefix-social-media a:hover'),
						'props'    => array(
							'color' => 'socialMediaHoverColor',
							'background-color' => 'socialMediaColor'
						)
					)
				);

				self::add_styles(array(
					'attrs' => $attrs,
					'css'   => $dynamic_css,
				));
			}
		}
	}
}

Rise_Blocks_Profile_Card::get_instance()->init();
