<?php
/**
* A class to handle header
*
* @see https://wordpress.org/gutenberg/handbook/
* @since 2.1
*/

if ( !class_exists( 'Rise_Blocks_Header' ) ) {
    /**
     * Class Rise_Blocks_Header.
     */
    class Rise_Blocks_Header extends Rise_Blocks_Helper{
        
        public function __construct(){
            add_action( 'rise_blocks_header', array( $this, 'render' ) );
        }

        public function render(){
            ?>
                <div class="rise-blocks-header">
                    <?php dynamic_sidebar( 'rise-blocks-header' ); ?>
                </div>
           <?php
        }
    }

    new Rise_Blocks_Header();
}