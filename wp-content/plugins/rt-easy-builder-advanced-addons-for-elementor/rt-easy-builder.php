<?php

/**
* Plugin Name: RT Easy Builder - Advanced addons for Elementor
* Plugin URI: https://wordpress.org/plugins/rt-easy-builder-advanced-addons-for-elementor
* Description: RT Easy Builder Is A Bunch Of Advanced Extra Addons For The Popular Plugin Elementor Including A Demo Importer That Would Help To Import Any Readymade Starter Sites In One Click. Extra add ons cover all the essentials elements for creating perfect websites using Elementor Page Builder. A collection of 10+ premade stater templates will help you build your websites in one click import like Business, Charity, Education, Corporate, Magazine, Constructions, App Landing, News, Photography, Travel etc.
* Version: 2.1
* Author: risetheme
* Author URI: http://www.risethemes.com
* License: GPL3
* License URI: http://www.gnu.org/licenses/gpl.html
* Text Domain: rise-builder
*
*/
namespace RT_Easy_Builder;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( function_exists( '\\RT_Easy_Builder\\rt_freemius' ) ) {
    rt_freemius()->set_basename( false, __FILE__ );
} else {
    // DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE `function_exists` CALL ABOVE TO PROPERLY WORK.
    
    if ( !function_exists( '\\RT_Easy_Builder\\rt_freemius' ) ) {
        // ... Freemius integration snippet ...
        function rt_freemius()
        {
            global  $rt_freemius ;
            
            if ( !isset( $rt_freemius ) ) {
                // Activate multisite network integration.
                if ( !defined( 'WP_FS__PRODUCT_8214_MULTISITE' ) ) {
                    define( 'WP_FS__PRODUCT_8214_MULTISITE', true );
                }
                // Include Freemius SDK.
                require_once plugin_dir_path( __FILE__ ) . 'freemius/start.php';
                $rt_freemius = fs_dynamic_init( array(
                    'id'             => '8214',
                    'slug'           => 'rt-easy-builder',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_a4a1abc520ecd44108d9d2baa95a7',
                    'is_premium'     => false,
                    'premium_suffix' => 'Agency',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => array(
                    'first-path' => 'admin.php?page=rt-easy-builder',
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $rt_freemius;
        }
        
        // Init Freemius.
        rt_freemius();
        // Signal that SDK was initiated.
        do_action( 'rt_easy_builder_freemius_loaded' );
    }
    
    require plugin_dir_path( __FILE__ ) . 'class-builder.php';
}
