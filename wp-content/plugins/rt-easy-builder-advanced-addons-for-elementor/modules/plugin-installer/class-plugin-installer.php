<?php
namespace RT_Easy_Builder;
use Plugin_Upgrader;

class Plugin_Installer{

	public $path;
	public $zip;

	public function __construct( $args = false ){
		if( $args ){
			$this->path = $args[ 'path' ];
			$this->zip  = $args[ 'zip' ];
		}
	}

	public function is_installed() {
		
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$all_plugins = get_plugins();

		if ( !empty( $all_plugins[ $this->path ] ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function is_activated(){
		if( is_multisite() ){
			return is_plugin_active_for_network( $this->path );
		}else{

			$all_active_plugins = get_option('active_plugins');
			if( in_array( $this->path, $all_active_plugins ) ){
				return true;
			}
			return false;
		}
	}

	public function install() {
		
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		wp_cache_flush();

		$upgrader = new Plugin_Upgrader();
		$installed = $upgrader->install( $this->zip );

		return $installed;
	}

	public function upgrade() {
		
		include_once ABSPATH . 'wp-admin/includes/misc.php';
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		wp_cache_flush();

		$upgrader = new Plugin_Upgrader();
		$upgraded = $upgrader->upgrade( $this->zip );
		return $upgraded;
	}
}