<?php
/**
 * Render Profile Cards block
 *
 * @since 1.0.8
 * @package Rise Block
 */
if( !class_exists( 'Rise_Blocks_Social_Icons' ) ){
	
	class Rise_Blocks_Social_Icons extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.8
		* @var string
		*/
		protected $slug = 'social-icons';

		/**
		* Title of this block.
		*
		* @access protected
		* @since 1.0.8
		* @var string
		*/
		protected $title = '';

		/**
		* Description of this block.
		*
		* @access protected
		* @since 1.0.8
		* @var string
		*/
		protected $description = '';

		/**
		* SVG Icon for this block.
		*
		* @access protected
		* @since 1.0.8
		* @var string
		*/
		protected $icon = '<svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" height="24px" viewBox="0 0 128 128" width="24px" data-name="Layer 1"><g><path fill="#436DD3" d="m93.71 50.29h27.79a1.75 1.75 0 0 0 1.75-1.75v-11.56a6.1 6.1 0 0 0 -5.2-6.017 12.024 12.024 0 0 0 .817-1.921 11.83 11.83 0 1 0 -21.785 1.793c.023.044.051.084.075.128a6.1 6.1 0 0 0 -5.2 6.017v2.584l-4.095 2.285v-23.349a13.765 13.765 0 0 0 -13.747-13.75h-55.615a13.765 13.765 0 0 0 -13.75 13.75v91a13.765 13.765 0 0 0 13.75 13.75h55.615a13.765 13.765 0 0 0 13.75-13.75v-23.35l7.967 4.45a11.749 11.749 0 0 0 1.254 4.354c.024.046.053.088.077.133a6.1 6.1 0 0 0 -5.2 6.017v11.55a1.75 1.75 0 0 0 1.75 1.75h5.487.039s.026 0 .039 0h16.654.039s.025 0 .038 0h5.491a1.75 1.75 0 0 0 1.75-1.75v-11.554a6.093 6.093 0 0 0 -5.2-6.017 12 12 0 0 0 .819-1.926 11.822 11.822 0 1 0 -22.743-6.4l-8.263-4.611v-36.288l4.095-2.285v4.967a1.75 1.75 0 0 0 1.752 1.75zm26.04 50.81v9.8h-2.027v-3.507a1.75 1.75 0 0 0 -3.5 0v3.507h-13.232v-3.507a1.75 1.75 0 0 0 -3.5 0v3.507h-2.031v-9.8a2.6 2.6 0 0 1 2.6-2.59h1.829a11.786 11.786 0 0 0 15.42 0h1.851a2.593 2.593 0 0 1 2.59 2.59zm-15.95-18.965a8.335 8.335 0 1 1 -1.975 13.395l-.023-.021a8.317 8.317 0 0 1 2-13.374zm-85.3-73.885h55.615a10.264 10.264 0 0 1 10.2 9.189h-76a10.264 10.264 0 0 1 10.185-9.189zm55.615 111.5h-55.615a10.261 10.261 0 0 1 -10.25-10.25v-6.917h76.115v6.917a10.261 10.261 0 0 1 -10.25 10.25zm10.25-20.667h-76.115v-78.144h76.115v22.861l-12.386 6.915q-.283-.546-.589-1.076a1.747 1.747 0 0 0 -.219-.38 29.033 29.033 0 0 0 -16.823-13.03 1.734 1.734 0 0 0 -.234-.067 28.775 28.775 0 0 0 -15.626 0 1.815 1.815 0 0 0 -.207.059 29.034 29.034 0 0 0 -16.838 13.04 1.753 1.753 0 0 0 -.217.376 28.814 28.814 0 0 0 0 28.726 1.753 1.753 0 0 0 .217.376 29.035 29.035 0 0 0 16.857 13.042 1.743 1.743 0 0 0 .217.062 28.774 28.774 0 0 0 15.569 0 1.662 1.662 0 0 0 .222-.064 29.031 29.031 0 0 0 16.86-13.04 1.747 1.747 0 0 0 .219-.38q.306-.531.589-1.076l12.389 6.917zm-36.307-9.733v-9.9h9.142a27.968 27.968 0 0 1 -4.466 9.141 25.292 25.292 0 0 1 -4.676.759zm-8.176-.758a27.948 27.948 0 0 1 -4.466-9.141h9.142v9.9a25.265 25.265 0 0 1 -4.676-.759zm4.676-49.942v9.9h-9.142a27.939 27.939 0 0 1 4.466-9.141 25.265 25.265 0 0 1 4.676-.759zm8.176.758a27.978 27.978 0 0 1 4.466 9.141h-9.142v-9.9a25.292 25.292 0 0 1 4.676.759zm-4.676 36.543v-10.201h11.251a55.473 55.473 0 0 1 -1.219 10.2zm-13.532 0a55.568 55.568 0 0 1 -1.22-10.2h11.252v10.2zm10.032-23.9v10.2h-11.252a55.492 55.492 0 0 1 1.22-10.2zm3.5 10.2v-10.2h10.032a55.441 55.441 0 0 1 1.219 10.2zm12.783-13.7a38.788 38.788 0 0 0 -2.667-7.016 25.585 25.585 0 0 1 8.295 7.016zm-29.067 0h-5.628a25.606 25.606 0 0 1 8.3-7.016 38.788 38.788 0 0 0 -2.672 7.014zm-7.89 3.5h7.062a58.551 58.551 0 0 0 -1.141 10.2h-8.847a25.238 25.238 0 0 1 2.926-10.202zm5.921 13.7a58.529 58.529 0 0 0 1.141 10.2h-7.062a25.238 25.238 0 0 1 -2.926-10.2zm1.969 13.7a38.788 38.788 0 0 0 2.666 7.016 25.6 25.6 0 0 1 -8.294-7.016zm29.067 0h5.628a25.585 25.585 0 0 1 -8.295 7.016 38.743 38.743 0 0 0 2.667-7.016zm7.89-3.5h-7.062a58.519 58.519 0 0 0 1.141-10.2h8.847a25.223 25.223 0 0 1 -2.926 10.2zm-5.921-13.701a58.605 58.605 0 0 0 -1.14-10.2h7.061a25.223 25.223 0 0 1 2.926 10.2zm21.555 17.939-10.955-6.113a28.888 28.888 0 0 0 0-20.151l10.955-6.114zm19.435-62.169a8.331 8.331 0 0 1 9.627 13.371l-.025.025a8.331 8.331 0 1 1 -9.6-13.4zm-8.34 18.96a2.6 2.6 0 0 1 2.6-2.59h1.824a11.786 11.786 0 0 0 15.431 0h1.845a2.593 2.593 0 0 1 2.59 2.59v9.81h-2.027v-3.513a1.75 1.75 0 0 0 -3.5 0v3.513h-13.232v-3.513a1.75 1.75 0 0 0 -3.5 0v3.513h-2.031z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#32373C"/><path d="m46.308 104.413a6.75 6.75 0 1 0 6.75 6.75 6.757 6.757 0 0 0 -6.75-6.75zm0 10a3.25 3.25 0 1 1 3.25-3.25 3.254 3.254 0 0 1 -3.25 3.25z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#32373C"/></g> </svg>,
		';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.8
        * @var string
        */
        protected $demo_link = 'rise-blocks/social-icons';

		/**
		* To store Array of this blocks that user adds
		*
		* @access protected
		* @since 1.0.8
		* @var array
		*/
		protected $blocks = array();

		/**
		* The object instance.
		*
		* @static
		* @access protected
		* @since 1.0.8
		* @var object
		*/
		private static $instance;

		/**
		* Constructor Function.
		*
		* @static
		* @access protected
		* @since 1.0.8
		* @var object
		*/
		public function __construct(){
			$this->title       = esc_html__( 'Social Icons', 'rise-blocks' );
			$this->description = esc_html__( 'Add this block to share your energetic team members. You can add their photo, name, description and social profiles.', 'rise-blocks' );
		}

	   /**
		* Gets an instance of this object.
		* Prevents duplicate instances which avoid artefacts and improves performance.
		*
		* @static
		* @access public
		* @since 1.0.8
		* @return object
		*/
		public static function get_instance(){
			if ( ! self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}


	   /**
		* Generate & Print Frontend Styles
		* Called in wp_head hook
		* @access public
		* @since 1.0.8
		* @return null
		*/
		public function prepare_scripts_styles(){
			$blocks = $this->get_blocks();
			foreach( $blocks as $block ){
				$attrs = $block[ 'attrs' ];	
				
				$margin = self::get_initial_responsive_props();
				if( isset( $attrs[ 'margin' ] ) ){
					$margin = self::get_dimension_props( 'margin', $attrs[ 'margin' ] );
				}

				foreach( [ 'mobile', 'tablet', 'desktop' ] as $device ){
					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => array(						
							array(
								'selector' => '',
								'props' => $margin[ $device ]
							)
						),
					), $device );
				}

				self::add_styles(array(
					'attrs' => $attrs,
					'css' => array(
						array(
							'selector' => self::add_prefix( '.%prefix-social-icon-wrapper a' ),
							'props' => array(
								'font-size'  => array(
									'value' => !isset( $attrs[ 'fontSize' ] ) ? 25 : $attrs[ 'fontSize' ],
									'unit'  => 'px'
								)
							)
						)
					)
				));
			}
		}
	}
}

Rise_Blocks_Social_Icons::get_instance()->init();
