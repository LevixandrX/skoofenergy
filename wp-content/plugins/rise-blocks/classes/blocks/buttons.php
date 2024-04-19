<?php
/**
 * Render Advanced Buttons block
 *
 * @since 1.0.3
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Buttons' ) ){
	
	class Rise_Blocks_Buttons extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.3
		* @var string
		*/
		protected $slug = 'buttons';

		/**
		* Title of this block.
		*
		* @access protected
		* @since 1.0.3
		* @var string
		*/
		protected $title = '';

		/**
		* Description of this block.
		*
		* @access protected
		* @since 1.0.3
		* @var string
		*/
		protected $description = '';

		/**
		* SVG Icon for this block.
		*
		* @access protected
		* @since 1.0.3
		* @var string
		*/
		protected $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50" height="50" fill: "#3761cf">
  <path fill: "#3761cf" d="M 4 12 C 1.800781 12 0 13.800781 0 16 L 0 34 C 0 36.199219 1.800781 38 4 38 L 46 38 C 48.199219 38 50 36.199219 50 34 L 50 16 C 50 13.800781 48.199219 12 46 12 Z M 4 14 L 46 14 C 47.117188 14 48 14.882813 48 16 L 48 34 C 48 35.117188 47.117188 36 46 36 L 4 36 C 2.882813 36 2 35.117188 2 34 L 2 16 C 2 14.882813 2.882813 14 4 14 Z M 33.527344 22.308594 C 31.835938 22.308594 30.746094 23.445313 30.746094 25.277344 C 30.746094 27.113281 31.824219 28.25 33.527344 28.25 C 35.21875 28.25 36.296875 27.113281 36.296875 25.277344 C 36.296875 23.445313 35.21875 22.308594 33.527344 22.308594 Z M 6.914063 22.464844 L 6.914063 28.097656 L 9.617188 28.097656 C 10.824219 28.097656 11.589844 27.460938 11.589844 26.472656 C 11.589844 25.753906 11.015625 25.179688 10.28125 25.140625 L 10.28125 25.066406 C 10.878906 24.984375 11.328125 24.472656 11.328125 23.867188 C 11.328125 22.992188 10.667969 22.464844 9.542969 22.464844 Z M 13.015625 22.464844 L 13.015625 26.152344 C 13.015625 27.417969 13.980469 28.25 15.445313 28.25 C 16.910156 28.25 17.871094 27.417969 17.871094 26.152344 L 17.871094 22.464844 L 16.4375 22.464844 L 16.4375 26 C 16.4375 26.65625 16.082031 27.046875 15.445313 27.046875 C 14.808594 27.046875 14.449219 26.65625 14.449219 26 L 14.449219 22.464844 Z M 19.296875 22.464844 L 19.296875 23.613281 L 20.921875 23.613281 L 20.921875 28.097656 L 22.347656 28.097656 L 22.347656 23.613281 L 23.980469 23.613281 L 23.980469 22.464844 Z M 25.089844 22.464844 L 25.089844 23.613281 L 26.714844 23.613281 L 26.714844 28.097656 L 28.144531 28.097656 L 28.144531 23.613281 L 29.773438 23.613281 L 29.773438 22.464844 Z M 37.761719 22.464844 L 37.761719 28.097656 L 39.121094 28.097656 L 39.121094 24.894531 L 39.195313 24.894531 L 41.550781 28.097656 L 42.6875 28.097656 L 42.6875 22.464844 L 41.328125 22.464844 L 41.328125 25.636719 L 41.253906 25.636719 L 38.90625 22.464844 Z M 8.347656 23.472656 L 9.160156 23.472656 C 9.648438 23.472656 9.933594 23.714844 9.933594 24.117188 C 9.933594 24.515625 9.628906 24.761719 9.105469 24.761719 L 8.347656 24.761719 Z M 33.523438 23.496094 C 34.3125 23.496094 34.839844 24.191406 34.839844 25.277344 C 34.839844 26.367188 34.316406 27.0625 33.523438 27.0625 C 32.722656 27.0625 32.203125 26.367188 32.203125 25.277344 C 32.203125 24.191406 32.730469 23.496094 33.523438 23.496094 Z M 8.347656 25.628906 L 9.203125 25.628906 C 9.800781 25.628906 10.132813 25.886719 10.132813 26.347656 C 10.132813 26.824219 9.808594 27.089844 9.214844 27.089844 L 8.347656 27.089844 Z" />
</svg>';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.3
        * @var string
        */
        protected $demo_link = 'rise-blocks/advanced-buttons';

		/**
		* To store Array of this blocks that user adds
		*
		* @access protected
		* @since 1.0.3
		* @var array
		*/
		protected $blocks = array();

		/**
		* The object instance.
		*
		* @static
		* @access protected
		* @since 1.0.3
		* @var object
		*/
		private static $instance;

		/**
		* Constructor Function.
		*
		* @static
		* @access protected
		* @since 1.0.3
		* @var object
		*/
		public function __construct(){
			$this->title       = esc_html__( 'Advanced Buttons', 'rise-blocks' );
			$this->description = esc_html__( 'This block enables you to display information along with Icon and show it either in grid or in a row.', 'rise-blocks' );
		}

	   /**
		* Gets an instance of this object.
		* Prevents duplicate instances which avoid artefacts and improves performance.
		*
		* @static
		* @access public
		* @since 1.0.3
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
		* @since 1.0.3
		* @return null
		*/
		public function prepare_scripts_styles(){
			
			$this->get_blocks();
			foreach( $this->blocks as $block ){

                $attrs = $block[ 'attrs' ];
				$padding = self::get_dimension_props( 'padding', $attrs[ 'padding' ] );

				foreach( self::$devices as $device ){

					$css = array(
						array(
							'props' => $padding[ $device ]
						)
					);

					self::add_styles(
						array(
							'attrs' => $attrs,
							'css' => $css
						),
						$device
					);
				};
			}
		}
		
	}
}

Rise_Blocks_Buttons::get_instance()->init();
