<?php
/**
 * Render Advanced Heading block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Section' ) ){
	
	class Rise_Blocks_Section extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'section';

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
            width="60px" height="60px">
            <image  x="0px" y="0px" width="60px" height="60px"  xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFQAAABEBAMAAADtkw9pAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAJ1BMVEUAAAA3Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc////8iYH5XAAAAC3RSTlMAv2CAQM8gMBDvj8wlrmoAAAABYktHRAyBs1FjAAAAB3RJTUUH4wkXCzs58zhGCgAAAJVJREFUSMdjECQWCDHsJhZsHgxKt7gQAaLBSjcwEAGkh7ZSZnjgbBxOStngUek+6KNgWCllQ85GbkAZDpSMhayUGTVrMjCwoGTWIazUABoq1jClAlAB7+GldCK0DogmrJSEwBpYpWzGyACvUty5YDAqXYhUZeNN2iA5FP6gVlqCUtoMopJwVCmxSokEQ0spMc1MSLIFALO3TqRQ/idTAAAAAElFTkSuQmCC" />
        </svg>';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.0
        * @var string
        */
        protected $demo_link = 'rise-blocks/section';
        
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
			$this->title       = esc_html__( 'Section', 'rise-blocks' );
			$this->description = esc_html__( 'This block enables you to add a section with a desired layout that allows you to add other block within it.', 'rise-blocks' );
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

				$attrs = $block[ 'attrs' ];

				$padding = self::get_initial_responsive_props();
				if( isset( $attrs[ 'padding' ] ) ){
					$padding = self::get_dimension_props( 'padding', $attrs[ 'padding' ] );				
				} 

				$container_width = self::get_initial_responsive_props();
				if( !isset( $attrs[ "containerType" ] ) && isset( $attrs[ 'containerWidth' ] ) ){
					$container_width = self::get_responsive_props( $attrs[ 'containerWidth' ], 'max-width' );
				}

				$shape_height = self::get_initial_responsive_props();
				if( isset( $attrs[ 'shapeHeight' ] ) ){
					$shape_height = self::get_responsive_props( $attrs[ 'shapeHeight' ], 'height' );
				}

				$margin = self::get_initial_responsive_props();
				if( isset( $attrs[ 'margin' ] ) ){
					$margin = self::get_dimension_props( 'margin',
						$attrs[ 'margin' ]
					);
				}

				$shape_margin = '';
				if( isset( $attrs[ 'shapeHeight' ] ) ){
					$shape_margin = $shape_height; 
				}else{
					$shape_margin = array(
						'mobile' => array(
							'height' => array(
								'unit' => 'px',
								'value' => 50
							)
						),
						'tablet' => array(
							'height' => array(
								'unit' => 'px',
								'value' => 100
							)
						),
						'desktop' => array(
							'height' => array(
								'unit' => 'px',
								'value' => 150
							)
						)
					);
				}

				$verticalFlip = !isset( $attrs[ 'verticalFlip' ] ) ? true : false;

				foreach( [ 'mobile', 'tablet', 'desktop' ] as $device ){

					$width = [];
					if( !isset( $attrs[ "containerType" ] ) ){
						$width =  $container_width[ $device ]; 
					}
				
					$css = array(
						array(
							'selector' => '> .%prefix-section-wrapper',
							'props' => array_merge( $padding[ $device ], $width )
						),
						array(
							'selector' => '> .%prefix-section-wrapper .%prefix-section-shape svg',
							'props' => $shape_height[ $device ]
						),
						array(
							'selector' => '',
							'props' => $margin[ $device ]
						)
					);

					if( isset( $attrs[ 'shapePosition' ] ) && $attrs[ 'shapePosition' ] == 'top' && !$verticalFlip ){
						$css[] = array(
							'selector' => '> .%prefix-section-wrapper .%prefix-section-shape',
							'props' => array(
								'margin-bottom' => array(
									'value' => -$shape_margin[ $device ][ 'height' ][ 'value' ],
									'unit'  => 'px'
								)
							)
						); 
					}elseif( $verticalFlip ){
						$css[] = array(
							'selector' => '> .%prefix-section-wrapper .%prefix-section-shape',
							'props' => array(
								'margin-top' => array(
									'value' => -$shape_margin[ $device ][ 'height' ][ 'value' ],
									'unit'  => 'px'
								)
							)
						); 
					}

					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device );
				}

				$css = array();

				if( ( !isset( $attrs[ 'bgType' ] ) || 'image' == $attrs[ 'bgType' ] ) && isset( $attrs[ 'bgImage' ] ) && $attrs[ 'bgImage' ][ 'url'  ] != '' ){

					$css[] = array(
						'props'    => array(
							'background-image' => array(
								'unit' => '',
								'value' => 'url(' . $attrs[ 'bgImage' ][ 'url' ] . ')'
							),
							'background-attachment' => array(
								'unit' => '',
								'value' => isset( $attrs[ 'bgAttachment' ] ) ? 'fixed' : false
							),
							'background-position' => array(
								'unit' => '',
								'value' => isset( $attrs[ 'bgPosition' ] ) ? $attrs[ 'bgPosition' ] : 'center center'
							)
						)
					);

					if( isset( $attrs[ 'bgOverlay' ] ) ){

						$css[] = array(
							'selector' => '> .%prefix-section-wrapper > .%prefix-section-overlay',
							'props' => array(
								'background-color' => array(
									'unit' => '',
									'value' => $attrs[ 'bgOverlay' ]
								)
							)
						);
					}

				}elseif( isset( $attrs[ 'bgType' ] ) && 'color' == $attrs[ 'bgType' ] ){
					$css[] = array(
						'props' => array(
							'background-color' => 'bgColor'
						)
					);
				}

				if( isset( $attrs[ 'bgOverlay' ] ) ){

					$css[] = array(
						'selector' => '> .%prefix-section-wrapper > .%prefix-section-overlay',
						'props' => array(
							'background-color' => array(
								'unit' => '',
								'value' => $attrs[ 'bgOverlay' ]
							)
						)
					);
				}
				
				$css[] = array(
					'selector' => '> .%prefix-section-wrapper .%prefix-section-shape',
					'props' => array(
						'background-color' => 'shapeBgColor',
						'z-index' => 'shapeZIndex'   
					)
				);

				$css[] = array(
					'selector' => '> .%prefix-section-wrapper .%prefix-section-shape svg',
					'props' => array(
						'fill' => 'shapeColor'
					)
				);

				self::add_styles( array(
					'attrs' => $attrs,
					'css' => $css
				));
			}
		}
	}
}

Rise_Blocks_Section::get_instance()->init();
