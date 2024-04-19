<?php
/**
 * Render Profile Cards block
 *
 * @since 1.0.0
 * @package Rise Block
 */
if( !class_exists( 'Rise_Blocks_Profile_Cards' ) ){
	
	class Rise_Blocks_Profile_Cards extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'profile-cards';

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
            <image  x="0px" y="0px" width="60px" height="60px"  xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFQAAABJCAMAAACU/fG2AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAY1BMVEUAAAA3Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc9df9ibsOfN2PPm6/n////a4fZpidtEa9K0xO3BzvCouupQddWCnOF2kt7z9fyPpuR9OnzQAAAAEHRSTlMAMEBwgBBgr++fz1Dfv48goZURBQAAAAFiS0dEFeXY+aMAAAAHdElNRQfjCRcMBCdUpkfQAAABtElEQVRYw+3Y25aCIBQGYBRUtJwIM62m7P2fckZA87BRRGatueC/lPwWRyEQ0iQIMcFhgJwlihPWJYkjJyShbBhK9rN4TAoW76xmyqCkeyobZQxOtkPtzTMvLuW14OdetTa7tldF2aWouh6wNA/y9fpWDnOv5eODXYfKca+v5ThXqVKrbiWw2avEBj2KVx/lPA9ZVeserUoolW2vyqG/g+jddgKI1n+XcL7bwuN2VFTmqUGfotQcC4lIqh2mz1ClZDU4+nRll0KDFsw0NOhXkTuU5QjlzlEWTVGuQfkGNJyiLw362o7m7YhJvgHNhvU/W5xIM5QstF+2/ms7GognNVTVRn6mVk8Bc1S1H1pTT7PWQ6iasreZeZMF6x8pAO1mwnSpPphhRUH0pM4Rr2G/Nmo20ZMdimI102p+UeSFq22PxesmjKpp1eb85py/+23fbIOCUYQ1q8TsNKVB0YECJDXcnXQoOiUzMzEYo2X0t2jMJqEhuYiKo7Q8qmXbDtKLqG086lGPetSjHvWoRz36n9EsdBM8RN3mj9BkPzLN7A7FQdorMbyfGSUXfxIiR0Mv094J/ABS15FoWuZMUQAAAABJRU5ErkJggg==" />
        </svg>';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.0
        * @var string
        */
        protected $demo_link = 'rise-blocks/profile-cards';

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
			$this->title       = esc_html__( 'Profile Cards', 'rise-blocks' );
			$this->description = esc_html__( 'Add this block to share your energetic team members. You can add their photo, name, description and social profiles.', 'rise-blocks' );
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

				/* Gutter Width */
				$responsive_gutter_val = array(
					'desktop' => array(
						'items_per_row' => $attrs['itemsPerRow'], 
						'gutter'=> $attrs['gutter'] 
					),
					'tablet' => array( 'gutter'=> $attrs['gutter'] ),
					'mobile' => array( 'gutter'=> $attrs['gutter'] ),
				);

				$selector = self::add_prefix('.%prefix-block-lists > div');

				$responsive_css = ( 'circle' === $attrs['activeLayout']) 
							?  self::get_gutter_properties($selector, $responsive_gutter_val, 50) 
							:  self::get_gutter_properties($selector, $responsive_gutter_val);

				foreach( $responsive_css as $key => $css ){
					self::add_styles(
						array(
							'attrs' => $attrs,
							'css' => $css
						),
						$key
					);
				} 
			}
		}
	}
}

Rise_Blocks_Profile_Cards::get_instance()->init();
