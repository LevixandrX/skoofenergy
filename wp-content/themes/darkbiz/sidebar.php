<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @since 1.0.0
 *
 * @package Darkbiz WordPress Theme
 */

if ( is_active_sidebar( 'darkbiz_sidebar' ) ) { ?>
	<aside id="secondary" class="widget-area">
		<?php 
			$sidebar = apply_filters( Darkbiz_Theme::fn_prefix( 'sidebar' ), 'darkbiz_sidebar' );
			dynamic_sidebar( $sidebar ); ?>
	</aside><!-- #secondary -->
<?php }else{ ?>
    <aside id="secondary" class="widget-area">	    	
       <?php 
	       Darkbiz_Theme::the_default_search();
	       Darkbiz_Theme::the_default_recent_post();
	       Darkbiz_Theme::the_default_archive();
       ?>
    </aside>
<?php }?>

