<?php
namespace RT_Easy_Builder;

class Builder{

	public $modules = array();
	public static $module_instances = array();
	public static $instance = null;

	public function init( $modules ){
		/**
		 * Display admin error message if PHP version is older than 5.3.2
		 * Otherwise execute the main plugin class.
		 */
		if ( version_compare( phpversion(), '5.3.2', '<' ) ) {
			add_action( 'admin_notices', array( $this, 'old_php_admin_error_notice' ) );
		}else{
			// Set plugin constants.
			$this->set_plugin_constants();
			$this->modules = $modules;
			add_action( 'plugins_loaded', array( $this, 'require_modules' ) );
		}
	}

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return Builder the *Singleton* instance.
	 */
	public static function get_instance() {

		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Returns instance of module
	 *
	 * @return object
	 */
	public function get_module( $module = false ){
        if( $module ){
            return self::$module_instances[ $module ];
        }
    }

	/**
	 * Set plugin constants.
	 *
	 * Path/URL to root of this plugin, with trailing slash and plugin version.
	 */
	public function set_plugin_constants(){

		if( !defined( 'RT_EASY_BUILDER_PATH' ) ){
			define( 'RT_EASY_BUILDER_PATH', plugin_dir_path( __FILE__ ) );
		}

		if( !defined( 'RT_EASY_BUILDER_URL' ) ){
			define( 'RT_EASY_BUILDER_URL', plugin_dir_url( __FILE__ ) );
		}		

		if( !defined( 'RT_EASY_BUILDER_VERSION' ) ){
			define( 'RT_EASY_BUILDER_VERSION', '1.4' );
		}
	}

	/**
	 * Returns url appended with file name and path
	 *
	 * @return string
	 */
	public function get_directory_uri( $file = '' ){
		$file = apply_filters( 'rt_easy_builder_directory_uri', RT_EASY_BUILDER_URL . $file );
	    return esc_url( $file ); 
	}  

	/**
	 * inludes file once
	 *
	 * @return boolean
	 */
	public function require( $file, $query_args = false ){
		
		$file_path = RT_EASY_BUILDER_PATH . $file;

		$query_args = apply_filters( 'rt_easy_builder_require_query_args', $query_args, $file );
		
		if( $query_args ){
			foreach( $query_args as $var => $args ){
				$$var = $args;
			}
		}

		$file_path = apply_filters( 'rt_easy_builder_require_file', $file_path, $file, $query_args );
		
		if( file_exists( $file_path ) ){
			require $file_path;
			return true;
		}

		return false;
	}

	/**
	 * Returns namespace
	 *
	 * @return string
	 */
	public function get_namespace(){
		return 'RT_Easy_Builder\\';
	}

	/**
	 * loads modules
	 *
	 * @return void
	 */
	public function require_modules(){

		$this->modules = apply_filters( 'rt_easy_builder_modules', $this->modules );
		foreach( $this->modules as $module ){
			if( !class_exists( $this->get_class_name( $module ) ) ){

				//check if file exists in main directory
				$required = $this->require( 'modules/class-' . $module . '.php' );
				if( !$required ){
					$this->require( 'modules/' . $module .  '/class-' . $module . '.php' );
				}
			}

			$this->init_module( $module );
		}
	}

	public function ucfirst( $module ){
		$class = '';
		$ar = explode( '-', $module );
		foreach( $ar as $a ){
		    $class .= ucfirst( $a) . '_';
		}

		return rtrim( $class, '_' );
	}

	public function get_class_name( $module ){
		return $this->get_namespace() . $this->ucfirst( $module );
	}

	/**
	 * initialize modules and save it to an array
	 *
	 * @return void
	 */
	public function init_module( $module ){

		$class = $this->get_class_name( $module );

		self::$module_instances[ $module ] = new $class();
	}

	/**
	 * Display an admin error notice when PHP is older the version 5.3.2.
	 * Hook it to the 'admin_notices' action.
	 */
	public function old_php_admin_error_notice() {
		$message = sprintf( esc_html__( 'The %2$sRT Easy Builder%3$s plugin requires %2$sPHP 5.3.2+%3$s to run properly. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.3.2.%4$s Your current version of PHP: %2$s%1$s%3$s', 'rise-builder' ), phpversion(), '<strong>', '</strong>', '<br>' );

		printf( '<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}
}

// modules are loaded under "plugins_loaded" hook
Builder::get_instance()->init(array( 
	'plugin-page',
	'script-handler', 
	'plugin-installer', 
	'importer', 
	'elementor' 
));