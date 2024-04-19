<?php if ( $settings[ 'slides' ] ): ?>
	<?php
		$args = array(
			'dots'           => $settings[ 'show_dots' ],
			'infinite'       => $settings[ 'infinite' ],
			'slides_to_show' => $settings[ 'slides_to_show' ],
			'slide_gap'      => $settings[ 'slide_gap' ],
			'show_arrows'    => $settings[ 'show_arrows' ]
		);
	?>
	<div class="rt-featured-slider" data-settings="<?php echo esc_attr( json_encode( $args ) ); ?>">
		<?php foreach( $settings[ 'slides' ] as $key => $item ): ?>
			<div class="rt-featured-slider-item-wrapper elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
				<div class="rt-featured-slider-item">

					<?php if( !empty( $item[ 'title' ] ) ): ?>
						<h2 class="rt-featured-slider-title"><?php echo esc_html( $item[ 'title' ] ); ?></h2>
					<?php endif; ?>

					<?php if( !empty( $item[ 'content' ] ) ): ?>
						<div class="rt-featured-slider-content"><?php echo esc_html( $item[ 'content' ] ); ?></div>
					<?php endif; ?>

					<?php 
						$base->render_anchor_tag( $item['button_link_1'], array(
							'text'  => $item[ 'button_text_1' ],
							'class' => array( 'rt-featured-slider-link' ),
							'name'  => 'anchor-' . $key
						)); 
					?>
					
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>