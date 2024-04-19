<?php
namespace RT_Easy_Builder;
use \OCDI\OneClickDemoImport;
use \OCDI\Helpers;

$ocdi = OneClickDemoImport::get_instance();
$predefined_themes = $ocdi->import_files;
?>
<div class="wrap rise-builder-importer-wrapper">
	<h1></h1>
	<div class="ocdi rise-builder-importer">
		<h2 class="ocdi__title"><?php esc_html_e( 'Rise Demo Importer', 'rise-builder' ); ?></h2>
		<p class="notice-text"><?php esc_html_e( 'Importing a demo site and customizing it is a great way to save your development time. The demo sites can be imported from the demo listing "demo import" button below', 'rise-builder' ); ?></p>
		<?php
			// Display warrning if PHP safe mode is enabled, since we wont be able to change the max_execution_time.
			if ( ini_get( 'safe_mode' ) ) {
				printf(
					esc_html__( '%sWarning: your server is using %sPHP safe mode%s. This means that you might experience server timeout errors.%s', 'rise-builder' ),
					'<div class="notice  notice-warning  is-dismissible"><p>',
					'<strong>',
					'</strong>',
					'</p></div>'
				);
			}
		?>

		<!-- OCDI grid layout -->
		<div class="ocdi__gl  js-ocdi-gl">
			<?php
				// Prepare navigation data.
				$categories = Helpers::get_all_demo_import_categories( $predefined_themes );
			?>
			<?php if ( ! empty( $categories ) ) : ?>
				<div class="ocdi__gl-header  js-ocdi-gl-header">
					<nav class="ocdi__gl-navigation">
						<ul>
							<li class="active">
								<a href="#all" class="ocdi__gl-navigation-link  js-ocdi-nav-link">
									<?php esc_html_e( 'All', 'rise-builder' ); ?>
									<span class="demo-count"><?php echo count( $predefined_themes ); ?></span>
								</a>
							</li>
							<?php foreach ( $categories as $key => $name ) : ?>
								<li><a href="#<?php echo esc_attr( $key ); ?>" class="ocdi__gl-navigation-link  js-ocdi-nav-link"><?php echo esc_html( $name ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</nav>
					<div clas="ocdi__gl-search">
						<input type="search" class="ocdi__gl-search-input  js-ocdi-gl-search" name="ocdi-gl-search" value="" placeholder="<?php esc_html_e( 'Search demos...', 'rise-builder' ); ?>">
					</div>
				</div>
			<?php endif; ?>

			<div class="ocdi__gl-item-container  wp-clearfix  js-ocdi-gl-item-container">
				<?php foreach ( $predefined_themes as $index => $import_file ) : ?>
					<?php
						// Prepare import item display data.
						$img_src = isset( $import_file['import_preview_image_url'] ) ? $import_file['import_preview_image_url'] : '';
						// Default to the theme screenshot, if a custom preview image is not defined.
						if ( empty( $img_src ) ) {
							$theme = wp_get_theme();
							$img_src = $theme->get_screenshot();
						}

					?>
					<div class="ocdi__gl-item js-ocdi-gl-item" 
						data-categories="<?php echo esc_attr( Helpers::get_demo_import_item_categories( $import_file ) ); ?>" 
						data-name="<?php echo esc_attr( strtolower( $import_file['import_file_name'] ) ); ?>"
					>
						<?php if( $import_file[ 'pro' ] ): ?>
							<div class="ribbon"><span><?php esc_html_e( 'premium', 'rise-builder' ); ?></span></div>
						<?php endif; ?>
						<div class="ocdi__gl-item-image-container">
							<?php if ( ! empty( $img_src ) ) : ?>
								<img class="ocdi__gl-item-image" src="<?php echo esc_url( $img_src ) ?>">
							<?php else : ?>
								<div class="ocdi__gl-item-image  ocdi__gl-item-image--no-image">
									<?php esc_html_e( 'No preview image.', 'rise-builder' ); ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="ocdi__gl-item-footer<?php echo ! empty( $import_file['preview_url'] ) ? '  ocdi__gl-item-footer--with-preview' : ''; ?>">
							<h4 class="ocdi__gl-item-title" title="<?php echo esc_attr( $import_file['import_file_name'] ); ?>">
								<?php echo esc_html( $import_file['import_file_name'] ); ?>
							</h4>
							<div class="rt-builder-btn-wrapper">

								<?php if ( ! empty( $import_file['preview_url'] ) ) : ?>
									<a class="ocdi__gl-item-button  button preview-btn" href="<?php echo esc_url( $import_file['preview_url'] ); ?>" target="_blank"><?php esc_html_e( 'Preview', 'rise-builder' ); ?><span class="dashicons dashicons-welcome-view-site"></span></a>
								<?php endif; ?>

								<button class="show-details button">
									<p class="show-text"><?php echo esc_html__( 'Details', 'rise-builder' ); ?></p>	
									<span class="dashicons dashicons-smiley"></span>
								</button>
								
								<?php
									if( rt_freemius()->is_not_paying() && $import_file[ 'pro' ] ){
										// if free plugin and is pro demo
										?>
										<a href="//wpactivethemes.com/download/full-site-editing-themes/" target="_blank" class="ocdi__gl-item-button  button  button-primary buy-link">
											<?php esc_html_e( 'Buy', 'rise-builder' ); ?><span class="dashicons dashicons-arrow-right-alt"></span>
										</a>
										<?php
									}

									if( !rt_freemius()->is_not_paying() || !$import_file[ 'pro' ] ){
										// if paying or is free demo
										?>
										<a class="ocdi__gl-item-button  button  button-primary" href="<?php echo $ocdi->get_plugin_settings_url( [ 'step' => 'import', 'import' => esc_attr( $index ) ] ); ?>">
											<?php esc_html_e( 'Import', 'rise-builder' ); ?><span class="dashicons dashicons-download"></span>
										</a>
										<?php
									}
								?>
							</div>

							<div class="demo-requirement">
								<button class="show-details close-link">								
									<span class="dashicons dashicons-no-alt"></span>
								</button>
								<div class="required-theme">
									<?php esc_html_e( 'Theme:', 'rise-builder' ); ?> <a href="<?php echo esc_url( $import_file[ 'theme' ][ 'link' ] ); ?>" target="_blank"><?php echo esc_html( $import_file[ 'theme' ][ 'name' ] ); ?></a>
								</div>
								<?php if( $import_file['required_plugins'] ): ?>
									<div class="required-plugin">
										<?php esc_html_e( 'Required Plugins:', 'rise-builder' ); ?>
										<ul>
											<?php foreach( $import_file[ 'required_plugins' ] as $count => $plugin ): ?>
												<li>
													<a href="<?php echo esc_url( '//wordpress.org/plugins/' . $plugin['slug'] ); ?>" target="_blank">
														<?php echo esc_html( $plugin[ 'name' ] ); ?>
													</a><?php echo count( $import_file[ 'required_plugins' ] ) != $count + 1 ? ',':''; ?>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>