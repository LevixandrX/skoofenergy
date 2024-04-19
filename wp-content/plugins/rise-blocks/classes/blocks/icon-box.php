<?php
/**
 * Render Icon Box block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Icon_Box' ) ){
	
	class Rise_Blocks_Icon_Box extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'icon-box';

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
		protected $icon = '';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.0
        * @var string
        */
        protected $demo_link = 'icon-box';

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
				$title_typo   = self::get_typography_props( $attrs[ 'titleTypo' ] );
				$content_typo = self::get_typography_props( $attrs[ 'contentTypo' ] );

				$icon_size = self::get_responsive_props( $attrs[ 'iconSize' ], 'font-size' );

				if( 'initial' != $attrs[ 'activeIconLayout' ] ){
					$icon_box_width  = self::get_responsive_props( $attrs[ 'iconsBoxSize' ], 'width' );
					$icon_box_height = self::get_responsive_props( $attrs[ 'iconsBoxSize' ], 'height' );
				}
				
				$box_padding = self::get_dimension_props( 'padding', $attrs[ 'boxPadding' ] );
				$heading_padding = self::get_dimension_props( 'padding', $attrs[ 'headingPadding' ] );


				foreach( self::$devices as $device ){

					$css = array(
						array(
							'selector' => self::add_prefix( '.%prefix-icon-box .%prefix-content .%prefix-title' ),
							'props'    => array_merge( $title_typo[ $device ], $heading_padding[ $device ] )
						),
						array(
							'selector' => self::add_prefix( '.%prefix-icon-box' ),
							'props'    => $box_padding[ $device ]
						),
						array(
							'selector' => self::add_prefix( '.%prefix-icon-box .%prefix-icon-wrapper .%prefix-icon' ),
							'props'    => $icon_size[ $device ]
						),
						array(
							'selector' => self::add_prefix( '.%prefix-icon-box .%prefix-content .%prefix-description' ),
							'props'    => $content_typo[ $device ]
						)
					);
					
					if( 'initial' != $attrs[ 'activeIconLayout' ] && isset( $icon_box_width ) && isset( $icon_box_height ) ){
						$css[] = array(
							'selector' => self::add_prefix( '.%prefix-icon-box .%prefix-icon-wrapper .%prefix-icon' ),
							'props'    => array_merge( $icon_box_width[ $device ], $icon_box_height[ $device ] )
						); 
					}

					if( $attrs[ 'isImageIcon' ] ){

						$image_icon = array(
							'width' => array(
								'unit'  => $attrs[ 'imageWidth' ][ 'activeUnit' ],
								'value' => $attrs[ 'imageWidth' ][ 'values' ][ $device ]
							)
						);

						if( 'desktop' == $device ){
							$image_icon[ 'border-radius' ] = array(
								'unit' => '%',
								'value' => $attrs[ 'imageRadius' ]
							);
						}

						$css[] = array(
							'selector' => self::add_prefix( '.%prefix-icon-wrapper img' ),
							'props' => $image_icon
						);
					}
					
					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device );
				}

				$dynamic_css = array(
					array(
						'selector' => self::add_prefix( '.%prefix-icon-box .%prefix-content .%prefix-title' ),
						'props' => array(
							'color' => 'titleColor'
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-icon-box .%prefix-content .%prefix-description' ),
						'props' => array(
							'color' => 'contentColor'
						)
					),
					array(
						'selector' => '',
						'props' => array(
							'background-color' => 'boxBackgroundColor'
						)
					),
				);

				$icon_props = [];
				if( isset($attrs['iconColors'])){
					$activeLayout = $attrs['activeIconLayout'];
					if(isset($attrs['iconColors'][$activeLayout]['color'])){
						$icon_props['color'] = array( 'value'=> $attrs['iconColors'][$activeLayout]['color']);
					}
					if('frame' === $activeLayout && isset($attrs['iconColors'][$activeLayout]['borderColor'])){
						$icon_props['border-color'] = array( 'value' => $attrs['iconColors'][$activeLayout]['borderColor']);
					}else if( 'stack' === $activeLayout && $attrs['iconColors'][$activeLayout]['backgroundColor']){
						$icon_props['background-color'] = array( 'value' => $attrs['iconColors'][$activeLayout]['backgroundColor']);
					}
				}
				
				if( 'frame' == $attrs[ 'activeIconLayout' ] ){
					$icon_props['border-width'] = array('value' => $attrs[ 'iconBorderWidth' ], 'unit'=>'px');
				}
				
				if( isset( $icon_props) ){		
					$dynamic_css[] = array(
						'selector' => self::add_prefix( '.%prefix-icon-box .%prefix-icon-wrapper .%prefix-icon' ),
						'props' => $icon_props
					);
				}

				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => $dynamic_css,
				));
			}

		}
	}
}

Rise_Blocks_Icon_Box::get_instance()->init();
