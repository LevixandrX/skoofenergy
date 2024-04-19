<?php
/**
 * Template part for displaying the welcome notice
 *
 */
?>
<?php 
	$theme_detail = get_query_var( 'rt_welcome_notice_theme', false );
	if( !$theme_detail ){
		return;
	}
	$theme_name = $theme_detail[ 'name' ];

	$is_available = Darkbiz_Welcome_Notice::is_plugin_installed();
	$is_activated = Darkbiz_Welcome_Notice::is_plugin_activated();

	if( $is_available && !$is_activated ){
		$text = esc_html__( 'Clicking the button will activate it.', 'darkbiz' );
	}else{
		$text = esc_html__( 'Clicking the button will install and activate it.', 'darkbiz' );
	}
?>
<div class="notice notice-info is-dismissible rt-notice-wrapper">
    <div class="rt-welcome-notice">
		<div class="notice-content">
			<div class="notice-heading">
				<p>
					<?php printf( '%s %s',
						esc_html__( 'Thank you for installing', 'darkbiz' ),
						$theme_name
					); ?>						
				</p>
			</div>
			<?php
				printf( '<p>%s <a href="%s" target="_blank">%s</a> %s %s</p>',
					esc_html__( 'Welcome! In order to import our', 'darkbiz' ),
					esc_url( 'https://riseblocks.com/rt-easy-builder/starter-templates/' ),
					esc_html__( 'Starter Templates,', 'darkbiz' ),
					esc_html__( 'we’ve assembled an importer plugin to get you started.', 'darkbiz' ),
					$text
				);
			?>
			<div class="rt-welcome-notice-container">
				<button href="<?php echo esc_url( '#' ) ?>" class="rt-welcome-notice-started button-primary" data-status=<?php  echo $is_available && !$is_activated ? 'active' : 'install'; ?> >
					<?php
					if( $is_available && !$is_activated ){
						esc_html_e( 'Activate Plugin', 'darkbiz' );
					}else{						
						printf( '%s %s',
							esc_html__( 'Get started with', 'darkbiz' ),
							$theme_name
						);
					}
					?>
				</button>

				<button class="rt-welcome-notice-closed button-primary">
					<?php esc_html_e( 'Close', 'darkbiz' ); ?>
				</button>
			</div>
		</div>
	</div>
</div>