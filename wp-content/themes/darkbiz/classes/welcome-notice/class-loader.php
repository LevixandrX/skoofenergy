<?php
/**
 * Modules for welcome notice and plugin installer
 *
 */

if( !class_exists( 'Darkbiz_Welcome_Notice' ) ){	
	class Darkbiz_Welcome_Notice{

		public static $theme_detail = array();
		public static $plugin_zip  = 'https://downloads.wordpress.org/plugin/rt-easy-builder-advanced-addons-for-elementor.zip';
		public static $plugin_path = 'rt-easy-builder-advanced-addons-for-elementor/rt-easy-builder.php';
		public static $pro_plugin_path = 'rt-easy-builder-premium/rt-easy-builder.php';

		/**
		 * Check Plugin present or not
		 *
		 * @static
		 * @access public
		 * @return boolean
		 *
		 */

		public static function is_plugin_installed(){
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$all_plugins = get_plugins();

			if ( !empty( $all_plugins[ self::$plugin_path ] ) ) {
				return true;
			}else{
				return false;
			}
		}

		/**
		 * Check Activated present or not
		 *
		 * @static
		 * @access public
		 * @return boolean
		 *
		 */
		public static function is_plugin_activated(){
			if( is_multisite() ){
				return is_plugin_active_for_network( self::$plugin_path );
			}else{
				$all_active_plugins = get_option('active_plugins');
				if( in_array( self::$plugin_path, $all_active_plugins ) || in_array( self::$pro_plugin_path, $all_active_plugins ) ){
					return true;
				}
				return false;
			}
		}

		/**
		 * Main Function to initilize
		 *
		 * @static
		 * @access public
		 * @return object
		 *
		 */
		public static function notice_init( $theme_name = false ){

			$is_available = self::is_plugin_installed();
			$is_activated = self::is_plugin_activated();

			if( !$theme_name || $is_activated ){
				return;
			}else{
				self::$theme_detail['name'] = $theme_name;
			}
			# welcome Note
			add_action( 'admin_notices', array( __CLASS__, 'display_welcome_notice' ), 20 );


			# enqueue the script and style on admin.
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'module_admin_scripts' ) );

			# ajax call
			add_action( 'wp_ajax_rt_welcome_ajax_action', array( __CLASS__, 'rt_welcome_ajax_action' ) );

			# ajax close
			add_action( 'wp_ajax_rt_welcome_ajax_action_close', array( __CLASS__, 'rt_welcome_ajax_action_close' ) );
		}

		public static function rt_welcome_ajax_action_close(){
			$response = array(
				'data' => array(
					'message' => esc_html__( 'Invalid Access', 'darkbiz' )
				),
				'status' => 400
			);

			if( wp_verify_nonce( $_POST['nonce'], 'rt-welcome-nonce' ) ){
				set_transient( 'darkbiz_welcome_notice', 'dismiss_notice', 3*MONTH_IN_SECONDS );

				$response[ 'data' ][ 'message' ] = esc_html__( 'Notice dismissed.', 'darkbiz' );
				$response[ 'status' ] = 200;
			}
			wp_send_json( $response[ 'data' ], $response[ 'status' ] );
		}
		
		public static function rt_welcome_ajax_action(){
			$response = array(
				'data' => array(
					'message' => esc_html__( 'Invalid Access', 'darkbiz' )
				),
				'status' => 400
			);

			if( wp_verify_nonce( $_POST['nonce'], 'rt-welcome-nonce' ) ){

				if( isset( $_POST[ 'status' ] ) && 'install' == $_POST[ 'status' ] ){
					include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
					wp_cache_flush();

					$upgrader = new Plugin_Upgrader();
					$installed = $upgrader->install( self::$plugin_zip);

					if ( !is_wp_error( $installed ) && $installed ) {
						activate_plugin( self::$plugin_path );
					}
				}elseif( isset( $_POST[ 'status' ] ) && 'active' == $_POST[ 'status' ] ){
					activate_plugin( self::$plugin_path );
				}
				$response[ 'data' ][ 'message' ] = esc_html__( 'Plugin Installed and Activated Successfully', 'darkbiz' );
				$response[ 'status' ] = 200;
			}

			wp_send_json( $response[ 'data' ], $response[ 'status' ] );
		}

		/**
		 * Display welcome notice
		 *
		 * @static
		 * @access public
		 *
		 */
		public static function display_welcome_notice(){
			if( 'dismiss_notice' == get_transient( 'darkbiz_welcome_notice' ) ){
				return;
			}

			set_query_var( 'rt_welcome_notice_theme', self::$theme_detail );
			get_template_part( 'classes/welcome-notice/templates/content', 'welcome' );
		}

		/**
		 * Enqueue styles and scripts on admin
		 *
		 * @static
		 * @access public
		 * @return object
		 *
		 */
		public static function module_admin_scripts(){
			wp_enqueue_style( 'welcome-style', get_theme_file_uri( '/classes/welcome-notice/assets/css/welcome-notice.css' ) );
			wp_enqueue_script( 'welcome-script', get_theme_file_uri( '/classes/welcome-notice/assets/js/welcome-notice.js' ), array( 'jquery' ) );

			$data = array(
				'admin_url'	=> admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce('rt-welcome-nonce'),
				'confirm_msg' => esc_html__( 'Are you sure?', 'darkbiz' ),
				'install_msg' => esc_html__( 'Installing...', 'darkbiz' ),
				'active_msg' => esc_html__( 'Activating...', 'darkbiz' )
			);
			wp_localize_script( 'welcome-script' , 'RTWELCOMENOTICE' , $data );
		}
	}
}