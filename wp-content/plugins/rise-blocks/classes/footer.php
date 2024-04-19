<?php
/**
* A class to handle footer
*
* @see https://wordpress.org/gutenberg/handbook/
* @since 2.1
*/

if ( !class_exists( 'Rise_Blocks_Footer' ) ) {
    /**
     * Class Rise_Blocks_Footer.
     */
    class Rise_Blocks_Footer extends Rise_Blocks_Helper{

        public function __construct(){
            add_action( 'rise_blocks_footer', array( $this, 'render' ) );
        }

        public function render(){
            dynamic_sidebar( 'rise-blocks-footer' );
        }
    }

    new Rise_Blocks_Footer();
}