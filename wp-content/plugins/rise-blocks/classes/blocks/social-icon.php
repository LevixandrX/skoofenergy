<?php
/**
 * Render Icon Box block
 *
 * @since 1.0.8
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Social_Icon' ) ){	
	class Rise_Blocks_Social_Icon extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.8
		* @var string
		*/
		protected $slug = 'social-icon';

		/**
		* Whether the block is insertable or not.
		*
		* Setting this variable to false will bypass in plugins landing page.
		* @access public
		* @since 1.0.8
		* @var string
		*/
		public $inserter = false;

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
		protected $icon = '';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.8
        * @var string
        */
        protected $demo_link = 'social-icon';

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
			
			$this->get_blocks();
			foreach( $this->blocks as $block ){
				 
				$attrs = $block[ 'attrs' ];
				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => array(
						array(
							'selector' => self::add_prefix( '.%prefix-social-icon-wrapper a' ),
							'props' => array(
								'height' => array(
									'value' => !isset( $attrs[ 'size' ] ) ? 45 : $attrs[ 'size' ],
									'unit'  => 'px'
								),
								'width'  => array(
									'value' => !isset( $attrs[ 'size' ] ) ? 45 : $attrs[ 'size' ],
									'unit'  => 'px'
								),
								'color' => array(
									'value' => !isset( $attrs[ 'color' ] ) ? '#ffffff' : $attrs[ 'color' ],
									'unit'  => ''
								),
								'background-color' => array(
									'value' => !isset( $attrs[ 'background' ] ) ? '#0693e3' : $attrs[ 'background' ],
									'unit'  => ''
								),
								'border-radius' => array(
									'value' => !isset( $attrs[ 'radius' ] ) ? 0 : $attrs[ 'radius' ],
									'unit'  => '%'
								)
							)
						)
					),
				));
			} 
		}
	}
}

Rise_Blocks_Social_Icon::get_instance()->init();
