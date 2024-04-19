<?php
/**
 * Template part for displaying inner banner in pages
 *
 * @since 1.0.0
 * 
 * @package Darkbiz WordPress Theme
 */
?>
<div class="<?php echo esc_attr( Darkbiz_Helper::get_inner_banner_class() ); ?>" <?php Darkbiz_Helper::the_header_image(); ?>> 
	<div class="container">
		<?php
			Darkbiz_Helper::the_inner_banner();
			Darkbiz_Helper::the_breadcrumb();
		?>
	</div>
</div>
