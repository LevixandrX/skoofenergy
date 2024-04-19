<div class="rt-team-box-wrapper <?php echo esc_attr( $settings[ 'general_layout' ] ); ?>">
	<div class="rt-team-box-inner">
		<?php if( isset( $settings[ 'team_image' ] ) ): ?>
			<div class="rt-team-image">
				<img src="<?php echo esc_url( $settings[ 'team_image' ][ 'url' ] ); ?>" alt="">
			</div>
		<?php endif; ?>
		<div class="rt-team-content">
			<h3 class="rt-team-name"><?php echo esc_html( $settings[ 'team_name' ] ); ?></h3>
			<h4 class="rt-team-designation"><?php echo esc_html( $settings[ 'team_designation' ] ); ?></h4>
			<p class="rt-team-description"><?php echo wp_kses_post( $settings[ 'team_description' ] ); ?></p>
			<?php if( isset( $settings[ 'team_social' ] ) ): ?>
				<ul class="rt-team-social-links">
					<?php foreach( $settings[ 'team_social' ] as $key => $item ): ?>

						<?php
							$button = $item[ 'team_social_link' ];
							if( !empty( $button[ 'url' ] ) ){

								$nofollow = $button[ 'nofollow' ] ? ' rel="nofollow"' : '';
								$attrs = array(
									'href'   => $button[ 'url' ],
									'target' => $button[ 'is_external' ] ? '_blank' : ''
								);

								if( isset( $button[ 'custom_attributes' ] ) && '' != $button[ 'custom_attributes' ] ){
									$ca = explode( ',', $button[ 'custom_attributes' ] );
									foreach( $ca as $a ){
										$at = explode( '|', $a );
										if( isset( $at[0] ) ){
											$attrs[ $at[0] ] = isset( $at[ 1 ] ) ? $at[ 1 ] : '';
										}
									}
								}

								$name = 'rt_team_attr_' . $key;
								$base->add_render_attribute( $name, $attrs );

								echo '<li><a ' . strip_tags( $base->get_render_attribute_string( $name ) )  . ' ' . strip_tags( $nofollow ) . '><i class="'. esc_attr( $item[ 'team_social_icon' ] ). '"></i></a></li>';
							}

						?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</div>