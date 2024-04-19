<?php
/**
 * Render Counter block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Counter' ) ){
	
	class Rise_Blocks_Counter extends Rise_Blocks_Base{

		/**
		* Name of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'counter';

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
            width="80px" height="84px">
            <image  x="0px" y="0px" width="80px" height="84px"  xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABUCAMAAAAiXkCJAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAANlBMVEUAAAA3Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc/////8VXeKAAAAEHRSTlMAEFCAn7+vIEDPYI/fMO9wLoXdHwAAAAFiS0dEEeK1PboAAAAHdElNRQfjCRcMBwNDiPDCAAABrUlEQVRYw+2Y2XLDIAxF2WRj44X//9qmBQdJiLSTZpo+6D4l9vWxhMhEwpgq63wAmLybjaxiCN5Z8wPFKd+1rJIBHhsSFKXycoT71OZ4dMAMkRnCdQe+7Evm8sS+H52BBInCB5mXc8LxHYLhIs7R4+cBh0uEsgbRULP29OoNGEV7Pu7FHBi2EXCS/fl8HOCVdAe0A/sVgZlHhkUGrtgCePn3AjzxOsCGvs0iMJEccMVrzmhJAi3hKgKB2HEFQgG2V5Q6tRi9CGxJlo2C77ELE/1RFEP03gf8UPscWU07oGdVAGFjvQG4vxoYFahABSpQgQpU4L8BvvyP3rwd2Nq90jMfYyAwYBKBrOFELXcdfpqhNJzADQyIWuKdvP8abVA3mWiRogh07UsOHo8QdSzFXT34hNp6KwKHY8VS3cOxYjIicDCZofFwNPi4AXAQwSbZse6bhgNxWZDQRCznsA+BRhpv8TxsvzNwoO3mx4MeAthuGQ8y83PgbWtsxB66g4yTzuCBHmT0QGNcqHlt0ymei6zNsPJzkR3uSkalUqlUf6H8nBSoQAX+DuifE0Z8AGQt1MV2BmPLAAAAAElFTkSuQmCC" />
        </svg>';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.0
        * @var string
        */
        protected $demo_link = 'rise-blocks/counter';
		/**
		* To store Array of this blocks
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
			$this->title       = esc_html__( 'Counter', 'rise-blocks' );
			$this->description = esc_html__( 'This block helps to display upto four statistical data like completed projects, no. of clients, etc.', 'rise-blocks' );
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
		public static function get_instance() {
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
				
				# Typography for number and text, content on mobile
				$number_typo = self::get_initial_responsive_props();
				if( isset( $attrs[ 'numberTypography' ] ) ){
					$number_typo = self::get_typography_props(  $attrs[ 'numberTypography' ] );
				}

				$text_typo = self::get_initial_responsive_props();
				if( isset( $attrs[ 'textTypography' ] ) ){
					$text_typo = self::get_typography_props(  $attrs[ 'textTypography' ] );
				}

				$section_padding = self::get_initial_responsive_props();
				if( isset( $attrs[ 'sectionPadding' ] ) ){
					$section_padding = self::get_dimension_props( 'padding', $attrs[ 'sectionPadding' ] );
				}

				$border_radius = self::get_initial_responsive_props();
				if( isset( $attrs[ 'itemsBorderRadius' ] ) ){
					$border_radius = self::get_dimension_props( 'border-radius', $attrs[ 'itemsBorderRadius' ]);
				}

				$text_margin = self::get_initial_responsive_props();
				if( isset( $attrs[ 'textMargin' ] ) ){
					$text_margin = self::get_dimension_props( 'margin', $attrs[ 'textMargin' ]);
				}	

				foreach( [ 'mobile', 'tablet', 'desktop' ] as $device ){

					$css = array(
						array(
							'selector' => self::add_prefix( '.%prefix-counter-number' ),
							'props'    => $number_typo[ $device ]
						),
						array(
							'selector' => self::add_prefix( '.%prefix-counter-text' ),
							'props'    => array_merge( $text_typo[ $device ], $text_margin[ $device ] )
						),
						array(
							'selector' => self::add_prefix( '.%prefix-counter' ),
							'props'    => $section_padding[ $device ]
						)
					);
					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device );
				}

				$dynamic_css = array(
					array(
						'selector' => self::add_prefix( '.%prefix-counter-line' ),
						'props' => array(
							'width'  => array(
								'unit' => 'px',
								'value' => isset( $attrs[ 'lineWidth' ] ) ? $attrs[ 'lineWidth' ] : false
							),
							'height' => array(
								'unit' => 'px',
								'value' => isset( $attrs[ 'lineHeight' ] ) ? $attrs[ 'lineHeight' ] : false
							),
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-counter' ),
						'props'    => array_merge( $border_radius[ 'desktop' ], array(
							'background-color' => 'boxBackgroundColor',
						))
					),
					array(
						'selector' => self::add_prefix( '.%prefix-counter-number' ),
						'props' => array(
							'color' => 'numberColor',
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-counter-text' ),
						'props' => array(
							'color' => 'textColor',
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-counter-line' ),
						'props' => array(
							'background-color' => 'lineColor',
						)
					),
				);

				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => $dynamic_css,
				));
			}
		}
	}
}

Rise_Blocks_Counter::get_instance()->init();
