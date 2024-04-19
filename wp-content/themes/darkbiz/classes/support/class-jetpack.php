<?php
/**
 * Activate Jetpack Plugin Support
 *
 * @since 1.0.0
 *
 * @package Darkbiz WordPress theme
 */
if( !class_exists( 'Support_Jetpack' ) ){
	class Support_Jetpack extends Darkbiz_Helper{
		/**
		 * constructor
		 *
		 * @since 1.0.0
		 *
		 * @package Darkbiz WordPress Theme
		 */
		public function __construct(){
			add_action( 'after_setup_theme', array( __CLASS__ , 'support' ) );
		}

		/**
		* Jetpack Plugin support
		*
		* @static
		* @access public
		* @since  1.0.0
		* @return array
		*
		* @package Darkbiz WordPress Theme
		*/
		public static function support(){

			add_theme_support( 'infinite-scroll', array(
			    'container'      => 'load-more',
			    'footer_widgets' => false,
			    'wrapper'        => true,
			    'render'         => array( __CLASS__, 'render' )
			) );
		}

		/**
		* Load more posts in infinity scroll
		*
		* @static
		* @access public
		* @since  1.0.0
		*
		* @package Darkbiz WordPress Theme
		*/
		public static function render() {
		    while (have_posts()) {
		    	?>
			    <div class="<?php echo esc_attr( Darkbiz_Theme::is_sidebar_active() ? 'col-md-6 col-lg-6' : 'col-md-4 col-lg-4' ); ?>">
			    	<?php
				        the_post();
				        get_template_part( 'templates/content/content' ); 
			        ?>
		        </div>
		    <?php }
		}
	}
}
new Support_Jetpack();