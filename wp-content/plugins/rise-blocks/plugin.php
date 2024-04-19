<?php
/**
 * Plugin Name: Rise Blocks - A Complete Gutenberg Page builder
 * Plugin URI: https://www.eaglevisionit.com/
 * Description: Create a stunning website or a desired blog of your choice with zero knowledge in coding.
 * Author: Rise Themes
 * Author URI: https://www.eaglevisionit.com/
 * Version: 3.5
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: rise-blocks
 */

# Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$env = get_theme_mod( 'rise-blocks-environment', 'production' );

define( 'Rise_Blocks_Dir', __DIR__ );
define( 'Rise_Blocks_File', __FILE__ );
define( 'Rise_Blocks_Url', plugin_dir_url( __FILE__ ) );
define( 'Rise_Blocks_Root', dirname( plugin_basename( Rise_Blocks_File ) ) );
define( 'Rise_Blocks_Version', '3.5' );
define( 'Rise_Blocks_Debug', $env == 'production' ? false: true );
define( 'Rise_Blocks_Prefix', 'rise-blocks' );

# Activation & PHP version checks.   
if( !function_exists( 'rise_blocks_requirement_check' ) ){

    /**
     * Check PHP and WordPress Version
     *
     * @since 1.0.0
     */
    function rise_blocks_requirement_check(){
        
        if ( ! version_compare( get_bloginfo( 'version' ), '4.7', '>=' ) ) {

            deactivate_plugins( plugin_basename( Rise_Blocks_File ) );

            /* translators: %s: WordPress version */
            $message = sprintf( esc_html__( 'Rise Blocks requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'rise-blocks' ), '4.7' );

            wp_die( sprintf( '<div class="error">%s</div>', $message) );
        }
    }

    register_activation_hook( Rise_Blocks_File,  'rise_blocks_requirement_check' );
}

/**
 * Check PHP version before we continue.
 * 
 * @since 1.0.0
 */
if ( !version_compare( PHP_VERSION, '5.6.0', '>=' ) ) {
    if ( !function_exists( 'rise_blocks_php_requirement_notice' ) ) {
        function rise_blocks_php_requirement_notice() {
            printf( '<div class="notice notice-error"><p>%s</p></div>', sprintf( __( '"Rise Blocks" requires PHP version 5.6 or higher, but PHP version %s is used on the site.', 'rise-blocks' ), PHP_VERSION ) );
        }
    }
    add_action( 'admin_notices', 'rise_blocks_php_requirement_notice' );
    return;
}

require plugin_dir_path( Rise_Blocks_File ) . 'classes/helper.php';
Rise_Blocks_Helper::includes( 'init' );