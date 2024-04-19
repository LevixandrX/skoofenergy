<?php
/**
 * Render Accordion Item block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Accordion_Item' ) ){
	
	class Rise_Blocks_Accordion_Item extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'accordion-item';

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
        protected $demo_link = 'accordion-item';

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
				$heading_type   = self::get_typography_props( $attrs[ 'headingTypo' ] );
				$content_typo = self::get_typography_props( $attrs[ 'contentTypo' ] );
				$heading_padding = self::get_dimension_props('padding', $attrs['headingPadding']);
				$content_padding = self::get_dimension_props('padding', $attrs['contentPadding']);

				foreach( self::$devices as $device ){

					$css = array(
						array(
							'selector' => self::add_prefix( '.%prefix-accordion-item-header a' ),
							'props'    => array_merge( array(
								'color' => 'headingColor'
							), $heading_type[ $device ] )
						),
						array(
							'selector' => self::add_prefix( '.%prefix-accordion-item-header .ui-icon:after' ),
							'props'    => array(
								'color' => 'headingColor'
							)
						),
						array(
							'selector' => self::add_prefix( '.%prefix-accordion-item-header.ui-state-active a' ),
							'props'    => array(
								'color' => 'headingActiveColor'
							)
						),
						array(
							'selector' => self::add_prefix( '.%prefix-accordion-item-header.ui-state-active .ui-icon:after' ),
							'props'    => array(
								'color' => 'headingActiveColor'
							)
						),
						array(
							'selector' => self::add_prefix( '.%prefix-accordion-item-header' ),
							'props'    => array_merge( array(
								'background-color' => 'headingBackground'
							), $heading_padding[ $device ] )
						),
						array(
							'selector' => self::add_prefix( '.%prefix-accordion-item-header.ui-state-active' ),
							'props' => array(
								'background-color' => 'headingActiveBackground'
							)
						),
						array(
							'selector' => self::add_prefix( '.%prefix-accordion-content-wrapper' ),
							'props'    => array_merge( $content_padding[ $device ], $content_typo[ $device ] )
						),
					);
					
					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device );
				}
			}

		}
	}
}

Rise_Blocks_Accordion_Item::get_instance()->init();
