<?php
/**
 * Displays the meta information
 *
 * @since 1.0.0
 *
 * @package Darkbiz WordPress Theme
 */?>

<?php if ( 'post' === get_post_type() ) : ?>
	<?php 
		$author   = darkbiz_get( 'post-author' );
		$date     = darkbiz_get( 'post-date' );
	if( $author || $date ) : ?>
		<div class="entry-meta 
			<?php 
				if( is_single() ){
					echo esc_attr( 'single' );
				} 
			?>"
		>
			<?php Darkbiz_Helper::get_author_image(); ?>
			<?php if( $author || $date ) : ?>
				<div class="author-info">
					<?php
						Darkbiz_Helper::the_date();			
						Darkbiz_Helper::posted_by();
					?>
				</div>
			<?php endif; ?>
		</div>	
	<?php endif; ?>
<?php endif; ?>