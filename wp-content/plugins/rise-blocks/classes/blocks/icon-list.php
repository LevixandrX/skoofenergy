<?php
/**
 * Render Icon List block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Icon_List' ) ){
	
	class Rise_Blocks_Icon_List extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'icon-list';

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
        protected $demo_link = 'icon-list';

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
		public function prepare_scripts_styles( $context ){
			
			$this->get_blocks();
			
			foreach( $this->blocks as $block ){
				 
				$attrs = $block[ 'attrs' ];
				
				$title_typo   = self::get_typography_props( $attrs[ 'titleTypo' ] );

				$icon_size = self::get_responsive_props( $attrs[ 'iconSize' ], 'font-size' );

				
				$box_padding = self::get_dimension_props( 'padding', $attrs[ 'iconListPadding' ] );
				$heading_padding = self::get_dimension_props( 'padding', $attrs[ 'headingPadding' ] );


				foreach( self::$devices as $device ){

					$css = array(
						array(
							'selector' => self::add_prefix( '.%prefix-icon-list .%prefix-content .%prefix-title' ),
							'props'    => array_merge( $title_typo[ $device ], $heading_padding[ $device ] )
						),
						array(
							'selector' => self::add_prefix( '.%prefix-icon-list' ),
							'props'    => $box_padding[ $device ]
						),
						array(
							'selector' => self::add_prefix( '.%prefix-icon-list .%prefix-icon-wrapper .%prefix-icon' ),
							'props'    => $icon_size[ $device ]
						)
					);
					
					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device );
				}

				$dynamic_css = array(
					array(
						'selector' => self::add_prefix( '.%prefix-icon-list .%prefix-content .%prefix-title' ),
						'props' => array(
							'color' => 'titleColor'
						)
					),
				);

				$icon_props = [];
				if( isset($attrs['iconColors'])){
					if(isset($attrs['iconColors'])){
						$icon_props['color'] = array( 'value'=> $attrs['iconColors']);
					}
				}
								
				if( isset( $icon_props) ){		
					$dynamic_css[] = array(
						'selector' => self::add_prefix( '.%prefix-icon-list .%prefix-icon-wrapper .%prefix-icon' ),
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

Rise_Blocks_Icon_List::get_instance()->init();
