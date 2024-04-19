<?php
if( '' != $settings[ 'category' ] ){
	$query = new WP_Query(array(
		'posts_per_page' => $settings[ 'per_page' ],
		'cat' => $settings[ 'category' ]
	));
?>
	<?php if( $query->have_posts() ): ?>
		<div class="rt-blog-thumbnail-wrapper rt-blog-thumbnail-items-row-<?php echo esc_attr( $settings[ 'per_row' ] ); ?>">
			<?php while( $query->have_posts() ): ?>
				<?php
					$query->the_post();
					$id = get_the_ID();
					global $post;
				?>
				   <div class="rt-blog-thumbnail">
				      <div class="rt-blog-thumbnail-inner">

				      	<?php if( "yes" == $settings[ 'show_thumbnail' ] && has_post_thumbnail() ): ?>
				      		<?php
				      			$src = get_the_post_thumbnail_url( $id, 'full' );
				      			$attachment_id = get_post_thumbnail_id( $id );
				      			$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
				      		?>
				      		<a href="<?php the_permalink(); ?>" class="rt-blog-thumbnail-image">
				      		    <img src="<?php echo esc_attr( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
				      		</a>
				      	<?php endif; ?>

				         <div class="rt-blog-thumbnail-content-wrapper">
				         	<?php if( "yes" == $settings[ 'show_title' ] ): ?>
				         		<h3 class="rt-blog-thumbnail-title">
				         			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				         		</h3>
				         	<?php endif; ?>
				           
				            <div class="rt-blog-thumbnail-meta">
				            	<?php if( "yes" == $settings[ 'show_date' ] ): ?>
					               <div class="rt-blog-thumbnail-date">
					                  <i class="fa fa-calendar-o"></i>
					                  <a href="<?php echo esc_url( get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') ) ) ?>">
					                      <span>
					                      	<?php echo esc_html( get_the_date() ); ?>
					                  	</span>
					                  </a>
					               </div>   
				               <?php endif; ?>            
				            </div>

			                <?php if( "yes" == $settings[ 'show_excerpt' ] && !empty( $post ) && !post_password_required( $post )  ): ?>
			            		<div class="rt-blog-thumbnail-content"><?php echo wp_kses_post( $post->post_excerpt ); ?></div>
			            	<?php endif; ?>

				         </div>
				      </div>
				   </div>
			<?php endwhile; ?>
		</div>
<?php
	wp_reset_postdata(); 
	endif; 
}
?>