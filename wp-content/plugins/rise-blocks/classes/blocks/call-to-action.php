<?php
/**
 * Render Call to action block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Call_To_Action' ) ){
	
	class Rise_Blocks_Call_To_Action extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'call-to-action';

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
		protected $icon = '<svg 
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="80px" height="81px">
            <image  x="0px" y="0px" width="80px" height="81px"  xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABRCAMAAAByk9E6AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAANlBMVEUAAAA3Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc/////8VXeKAAAAEHRSTlMAYK+/gI/vEEDPIDDfn1Bw/YMUmAAAAAFiS0dEEeK1PboAAAAHdElNRQfjCRcMCDqbFWQFAAAB6klEQVRYw+3X0XqDIAwGUBEEQWl5/6edqJFgBYxwtc9crdt6+itpwK5jPacU6wolHLGGAiipoFN5kOy58V+AerxV+jbIS72wFX/BF3zBF3zBF3xBAmimpqBaiJk1BO3611moViDfjzNyI9uBCzkYCHznfJgCGT51WTP502npBJtf5Tk6yNnP0BfP2Hkwiuj/cSx5pT6cHZUsgF/3UzOrAdX2lNALeZcsfZf35xilBL76o9fp4B5R+BXCpEyRxWmzRZTr22PS93oCTD8FLPPGHRGXGjkil15PgOnSav/CSbjCEzkRQWchYljZyeYaswTyY4ihN5kMWXoa7bvfiJ4cUo3J8p7094j/RPT9lOr1UWTquy7jeBFxJXEX6cKcjIrD7TwXbsziYEO1R7waNIEUBLDTqYhd2CcoCWHpriJCB2mKB4O2z3iUNQkRTSsPItrTb4fHHuwFcUTz3INBG0fc28kZuhf2guhTKhLivSAUqxHxXtBEjPcCJoSpFfFeYGG01Yho0NowLGvEYy+A70etCBHDjlIrRjtoC3F0rUUUUcsrsXwgTUXUasIivCCNbV8aXRsS4Uf6mGD4Xh0iA48ccB+0cO+n07njgddNi9gfaxmLTzyP4PuExYfemZdtvYqGKYjtvHWd5g+8+ANYNmjxKi51ogAAAABJRU5ErkJggg==" />
        </svg>';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.0
        * @var string
        */
        protected $demo_link = 'rise-blocks/call-to-action';

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
		public function __construct(){
			$this->title       = esc_html__( 'Call To Action', 'rise-blocks' );
			$this->description = esc_html__( 'This block helps to make attractive call to action section with customized background image and button.', 'rise-blocks' );
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
		* @since 1.0.0
		* @return null
		*/
		public function prepare_scripts_styles(){
			
			$this->get_blocks();
			foreach( $this->blocks as $block ){
				 
				$attrs = self::get_attrs_with_default( $block[ 'attrs' ] );
				
				# Typography for title on mobile
				$title_typo = self::get_initial_responsive_props();
				if( isset( $attrs[ 'titleTypography' ] ) ){
					$title_typo = self::get_typography_props( $attrs[ 'titleTypography' ] );	
				}

				$button_typo = self::get_initial_responsive_props();
				if( isset( $attrs[ 'buttonTypography' ] ) ){
					$button_typo  = self::get_typography_props( $attrs[ 'buttonTypography' ] );
				}
				
				$padding = self::get_initial_responsive_props();	
				if( isset( $attrs[ 'sectionPadding' ] ) ){
					$padding = self::get_dimension_props( 'padding',
						$attrs[ 'sectionPadding' ]
					);				
				}

				$title_padding = self::get_initial_responsive_props();
				if( isset( $attrs[ 'titlePadding' ] ) ){
					$title_padding = self::get_dimension_props( 'padding',
						$attrs[ 'titlePadding' ]
					);
				}

				$border_radius = self::get_initial_responsive_props();
				if( isset( $attrs[ 'buttonBodrderRadius' ] ) ){
					$border_radius = self::get_dimension_props( 'border-radius',
						$attrs[ 'buttonBodrderRadius' ]
					);
				}				

				$button_padding = self::get_initial_responsive_props();
				if( isset( $attrs[ 'buttonPadding' ] ) ){
					$button_padding = self::get_dimension_props( 'padding',
						$attrs[ 'buttonPadding' ]
					);	
				}

				$container_width = self::get_initial_responsive_props();
				if( isset( $attrs[ 'containerWidth' ] ) ){
					$container_width = self::get_responsive_props( $attrs[ 'containerWidth' ], 'max-width' );
				}
				
				$devices = array( 'mobile', 'tablet', 'desktop' );
				foreach( $devices as $device ){

					$css = array(
						array(
							'props' => $padding[ $device ]
						),
						array(
							'selector' => self::add_prefix( '.%prefix-cta-title-wrapper' ),
							'props'    => $title_padding[ $device ]
						),
                        array(
							'selector' => self::add_prefix( '.%prefix-cta-title' ),
							'props'    => $title_typo[ $device ]
						),
						array(
							'selector' => self::add_prefix( '.%prefix-cta-btn' ),
							'props'    => array_merge( $button_typo[ $device ], $button_padding[ $device ] )
						),
						array(
							'selector' => self::add_prefix( '.%prefix-cta-content' ),
							'props'    => $container_width[ $device ]
						)
					);

					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device );
				}

				$button_props =	array_merge( $border_radius[ 'desktop' ], array(
					'color'      => 'buttonTextColor',
					'background' => 'buttonBackground',
				));

				$background = array();
				if( !isset( $attrs[ 'bgType' ] ) && isset( $attrs[ 'sectionBgImage' ] ) && $attrs[ 'sectionBgImage' ][ 'url' ] != ''  ){
					# bgType is image when not set
					$background = array(
						array(
							'props' => array(
								'background-position' => 'sectionBgPosition',
								'background-attachment' => array(
									'unit'  => '',
									'value' => isset( $attrs[ 'sectionBgAttachment' ] ) ? 'fixed' : ''
								),
								'background-image' => array(
									'unit'  => '',
									'value' =>  'url(' . $attrs[ 'sectionBgImage' ][ 'url' ] . ')'
								)
							)
						));
				}

				$dynamic_css = array(
					array(
						'selector' => self::add_prefix( '.%prefix-cta-overlay' ),
						'props' => array(
							'background-color' => ( isset( $attrs[ 'bgType' ] ) && $attrs[ 'bgType' ] == 'color' ) ? 'bgColor' : 'sectionOverlay',
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-cta-title' ),
						'props' => array(
							'color' => 'titleColor'
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-cta-btn' ),
						'props' => $button_props
					),
					array(
						'selector' => self::add_prefix( '.%prefix-cta-btn:hover' ),
						'props' => array(
							'color'      => 'buttonHoverTextColor',
							'background' => array(
								'unit' => '',
								'value' => isset( $attrs[ 'buttonHoverBackground' ] ) ? $attrs[ 'buttonHoverBackground'] : '#000'
							),
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-cta-title-line' ),
						'props' => array(
							'background' => 'lineColor'
						)
					)
				);

				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => array_merge( $dynamic_css, $background ),
				));
			}

		}
	}
}

Rise_Blocks_Call_To_Action::get_instance()->init();
