<?php
/**
* Do things related with admin settings
*
* @since 1.0.0
*/

if ( ! class_exists( 'Rise_Blocks_Admin' ) ) {
    /**
     * Class Rise_Blocks_Admin.
     */
    class Rise_Blocks_Admin extends Rise_Blocks_Helper{
		
		protected static $page_slug  = 'rise_blocks';
		
		/**
		 * Add admin page and add redirection hook
		 * @since 1.0.0
		 */
    	public function __construct(){

            register_activation_hook( Rise_Blocks_File, array( __CLASS__, 'activation_reset' ) );
            register_deactivation_hook( Rise_Blocks_File, array( __CLASS__, 'deactivation_reset' ) );

    	    add_action( 'admin_menu', array( __CLASS__, 'admin_pages') );
            // this gives issue on demo importer plugin when it tries to install and activate the plugin
			//add_action( 'admin_init', array( __CLASS__, 'redirect') );
            add_action( self::add_prefix( '%prefix_admin_page' ), array( __CLASS__, 'admin_page_content' ) );
			if( isset( $_REQUEST['page'] ) && self::$page_slug == $_REQUEST['page'] ){
                add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );
                add_action( 'admin_head', array( __CLASS__, 'admin_internal_scripts' ) );
            }
		}

        /**
         * Replace with slug
         * @since 1.0.1
         */
        public static function add_slug( $str ){
            return str_replace( '%slug', self::$page_slug, $str );
        }

        public static function admin_internal_scripts(){
            ?>
            <script>
                jQuery(document).ready(function(){
                    jQuery(".rb-js-modal-btn").modalVideo();
                });
            </script>
            <?php
        }
		
		/**
        * Enqueue styles & scripts for backend
        *
        * @access public
        * @uses wp_enqueue_style
        * @return void
        * @since 1.0.0
        */
        public static function admin_scripts() {
			$scripts = array(
                array(
                    'handler'  => self::add_prefix( '%prefix-admin-css' ),
                    'style'    => 'templates/style.css',
                    'minified' => false
                ),
                array(
                    'handler'  => self::add_prefix( '%prefix-modal-video' ),
                    'style'    => 'vendors/modal-video/css/modal-video.min.css',
                    'version'  => '2.4.6',
                    'minified' => false
                ),
                array(
                    'handler' => self::add_prefix( '%prefix-modal-video' ),
                    'script'   => 'vendors/modal-video/js/jquery-modal-video.js',
                    'version' => '2.4.6',
                ),
                array(
                    'handler'  => self::add_prefix( '%prefix-admin-page-fonts' ),
                    'style'    => '//fonts.googleapis.com/css?family=Lato:100,300,400,600|Poppins:400,600,700&display=swap',
                    'absolute' => true,
                    'minified' => false
                ),
            );
			self::enqueue( $scripts );
		 }

    	/**
    	 * Activation Reset
    	 *
    	 * @since 1.0.0
    	 */
    	public static function activation_reset() {
    	    self::update_option( self::add_slug( '%slug_do_redirect' ), true );
    	}

    	/**
    	 * Deactivation Reset
    	 *
    	 * @since 1.0.0
    	 */
    	public static function deactivation_reset() {
    	    self::update_option( self::add_slug( '%slug_do_redirect' ), false );
    	}

    	/**
    	 * Redirect to plugin page when plugin activated
    	 *
    	 * @since 1.0.0
    	 */
    	public static function redirect(){
    		if ( self::get_option( self::add_slug( '%slug_do_redirect' ) ) ) {
    		    self::update_option( self::add_slug( '%slug_do_redirect' ), false );
    		    if ( ! is_multisite() ) {
    		        exit( wp_redirect( admin_url( 'admin.php?page=' . self::$page_slug ) ) );
    		    }
    		}
    	}

    	/**
    	 * Create admin page
    	 *
         * @access public
         * @uses current_user_can
         * @uses add_menu_page
         * @return void
    	 * @since 1.0.0
    	 */
    	public static function admin_pages(){

    	    if ( ! current_user_can( 'manage_options' ) ) {
    	        return;
    	    }

    	    add_menu_page( 
    	        esc_html__( 'Rise Blocks', 'rise-blocks' ), # page title
    	        esc_html__( 'Rise Blocks', 'rise-blocks' ), # menu title
    	        'manage_options', # capability
    	        self::$page_slug, # menu slug
    	        array( __CLASS__, 'template' ), # function
    	        self::get_plugin_directory_uri() . '/img/rise-icon.svg', # icon url
    	        110 # position
    	    );
    	}

        /**
        * include template file
        *
        * @access public
        * @return void
        * @since 1.0.0
        */
    	public static function template(){
            do_action( self::add_prefix( '%prefix_admin_page' ) );
    	}

        public static function admin_page_content(){
            self::includes( 'page', 'templates', 'admin' );
        }
    }
}
new Rise_Blocks_Admin();