<?php
/**
 * Render Icon Boxes block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Icon_Boxes' ) ){
	
	class Rise_Blocks_Icon_Boxes extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'icon-boxes';

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
	        <image  x="0px" y="0px" width="60px" height="60px"  xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFQAAABUCAMAAAArteDzAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAANlBMVEUAAAA3Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc/////8VXeKAAAAEHRSTlMAMN/vYCCAv0BQn68Qz49wRGY1vAAAAAFiS0dEEeK1PboAAAAHdElNRQfjCRcMAhstk5zRAAABeklEQVRYw+3Z2a6EIAwA0EJZlMHl/792FNQ7KrhAb6IJfZqgnCBCqw4w3tMGCgBqcwgJ9Gav3oZqRRP8F1VAE7qgBS1oQU9RWQ05qK4IUWaWmvMRNKj8rDIwrwlQgdvEbmwuapYR6mb+2dg8dDKNv2bW4rF6CRXeYEuDbX1Ny0ClG5gJzHGXjpq9CVCPjWhTUemufdes4j0uoG7+Arto3Ao8FeWRW+JuH0tD7XhExA50aWg1HpGxvm0GGp1sTY2q/0BzR2pjfRPn1K39YPbE9Lvv1qkJtNcZ69RvfRnuipCIMleVds1dH5vSS1lKh7YOw+imuIS6oW52qjePRnGW+dWu0nUYzoc3UPDlGZW/Wiv8AwDKLNTORZ9rvZRTZJCFTpl6FY2EXBSq9Xs2Hp1741lK6IXkygINOkxtrZRRSrCT8x7wfFrQ56N/i3SKgj4TbfUmKNA7UdCCFrSgL0K5pgn8RWnjTSjmI9uop+9ZlDG+zkqif3jmGN67v7E3h1uaGY7cAAAAAElFTkSuQmCC" />
	    </svg>';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.0
        * @var string
        */
        protected $demo_link = 'rise-blocks/icon-boxes';
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
			$this->title       = esc_html__( 'Icon Boxes', 'rise-blocks' );
			$this->description = esc_html__( 'This block enables you to display information along with Icon and show it either in grid or in a row.', 'rise-blocks' );
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
				
				/* Assign default values */
				$items_per_row = isset($attrs['itemsPerRow']) ? $attrs['itemsPerRow'] : 3;
				$gutter_size = isset($attrs['gutter']) ? $attrs['gutter']: 30;
				
				$selector = self::add_prefix( '.%prefix-save .%prefix-block-lists > div' ); 

				/* Gutter Width */
				$responsive_gutter_val = array(
					'desktop' => array(
						'items_per_row' => $items_per_row, 
						'gutter'=> $gutter_size 
					),
					'tablet' => array( 'gutter'=> $gutter_size ),
					'mobile' => array( 'gutter'=> $gutter_size ),
				);

				$responsive_css = self::get_gutter_properties($selector, $responsive_gutter_val);

				foreach( $responsive_css as $key => $css){
					self::add_styles(
						array(
							'attrs' => $attrs,
							'css' => $css
						),
						$key
					);
				};
			}
		}
	}
}

Rise_Blocks_Icon_Boxes::get_instance()->init();
