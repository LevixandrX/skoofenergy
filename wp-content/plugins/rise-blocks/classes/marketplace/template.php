<div class="rise-block-marketplace-wrapper">
	<?php 
		$response = wp_remote_get( 'https://eaglewoothemes.com/wp-json/wp/v2/marketplace' );

		if( !is_wp_error( $response ) ){

			$marketplace = json_decode( wp_remote_retrieve_body( $response ), true );
			if( !empty( $marketplace ) && ! is_wp_error( $marketplace ) ){
				foreach( $marketplace as $m ){
					if( !isset( $m[ 'custom_fields' ] ) ){
						continue;
					}
					$meta = $m[ 'custom_fields' ];
					?>
					<div class="rise-block-marketplace-items">
						<div class="rise-block-marketplace-items-box">
							<h3><?php echo esc_html( $m[ 'title' ][ 'rendered' ] ); ?></h3>
							<a href="<?php echo esc_url( $meta[ 'detail_link' ] ); ?>" target="_blank">
								<img src="<?php echo esc_url( $meta[ 'featured_image' ] ); ?>" >
							</a>
							<div class="button-wrapper">
								<a href="<?php echo esc_url( $meta[ 'detail_link' ] ); ?>" target="_blank">
									<?php _e( 'View Details', 'rise-blocks' ); ?>
								</a>

								<a href="<?php echo esc_url( $meta[ 'demo_link' ] ); ?>" target="_blank" class="view-demo">
									<?php _e( 'View Demo', 'rise-blocks' ); ?>
								</a>
							</div>
						</div>
					</div>
					<?php
						get_template_par('foter-nav');
				}
			}
		}
	?>
</div>
