<?php
if( '' != $settings[ 'category' ] ){
	$query = new WP_Query(array(
		'posts_per_page' => $settings[ 'per_page' ],
		'cat' => $settings[ 'category' ]
	));
?>
	<?php if( $query->have_posts() ): ?>
		<div class="rt-blog-listing-wrapper rt-blog-listing-items-row-<?php echo esc_attr( $settings[ 'per_row' ] ); ?>">
			<?php while( $query->have_posts() ): ?>
				<?php
					$query->the_post();
					$id = get_the_ID();
					global $post;
					if( "yes" == $settings[ 'show_category' ] ){
						$_cat = get_term( $settings[ 'category' ]);
						$cat = $base->make_category_arr( $_cat );
					}
				?>
				<div class="rt-blog-list">	
					<div class="rt-blog-list-inner">	

						<?php if( "yes" == $settings[ 'show_thumbnail' ] && has_post_thumbnail() ): ?>
							<?php
								$src = get_the_post_thumbnail_url( $id, 'full' );
								$attachment_id = get_post_thumbnail_id( $id );
								$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
							?>
							<a href="<?php the_permalink(); ?>" class="rt-blog-image">
							    <img src="<?php echo esc_attr( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
							</a>
						<?php endif; ?>

						<div class="rt-blog-content-wrapper">

							<?php if( "yes" == $settings[ 'show_title' ] ): ?>
								<h3 class="rt-blog-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
							<?php endif; ?>

							<div class="rt-blog-meta">
								<?php if( "yes" == $settings[ 'show_date' ] ): ?>
									<div class="rt-blog-date" >
										<i class="fa fa-calendar-o"></i>
									    <a href="<?php echo esc_url( get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') ) ) ?>">
									        <span>
									        	<?php echo esc_html( get_the_date() ); ?>
									    	</span>
									    </a>
									</div>
								<?php endif; ?>

								<?php if( "yes" == $settings[ 'show_category' ] ): ?>
							        <div class="rt-blog-category">
							        	<i class="fa fa-file"></i>
							            <a href="<?php echo esc_url( $cat[ 'link' ] ); ?>">
							                <span><?php echo esc_html( $cat[ 'name' ] ); ?></span>
							            </a>
							            <?php
							            	$category = get_the_category();
							            	$i = 1;
							            	foreach( $category as $c ){
							            		if( $i <= 1 && $c->term_id != $settings[ 'category' ] ){
							            			?>
							            			,<a href="<?php echo esc_url( get_category_link( $c->term_id ) ); ?>">
							            			    <span><?php echo esc_html( $c->name ); ?></span>
							            			</a>
							            			<?php
							            			$i++;
							            		}
							            	}
							            ?>
							        </div>
							    <?php endif; ?>
							</div>

						    <?php if( "yes" == $settings[ 'show_excerpt' ] && !empty( $post ) && !post_password_required( $post )  ): ?>
								<div class="rt-blog-content"><?php echo wp_kses_post( $post->post_excerpt ); ?></div>
							<?php endif; ?>

							<?php if( "yes" == $settings[ 'show_button' ] ): ?>
								<a href="<?php the_permalink(); ?>" class="rt-blog-link">
									<?php echo esc_html( $settings[ 'button_text' ] ); ?>
								</a>
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