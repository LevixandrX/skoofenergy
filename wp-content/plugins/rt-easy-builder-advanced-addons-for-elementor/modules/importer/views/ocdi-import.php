<?php
/**
 * The install plugins page view.
 *
 * @package ocdi
 */

namespace RT_Easy_Builder;
use \OCDI\OneClickDemoImport;
use \OCDI\PluginInstaller;

$plugin_installer = new PluginInstaller();
$ocdi             = OneClickDemoImport::get_instance();
$importer = Builder::get_instance()->get_module( 'importer' );
$predefined_themes = $ocdi->import_files;

$import_index = absint( $_GET[ 'import' ] );
if( isset( $predefined_themes[ $import_index ] ) ){
	$theme_plugins = $predefined_themes[ $import_index ];
}else{
	$theme_plugins = array();
}
   
?>

<div class="ocdi ocdi--install-plugins">

	<div class="ocdi__content-container">

		<div class="ocdi__admin-notices js-ocdi-admin-notices-container"></div>

		<div class="ocdi__content-container-content">
			<div class="ocdi__content-container-content--main">
				<?php if ( isset( $import_index ) ) : ?>
					<div class="ocdi-install-plugins-content js-ocdi-install-plugins-content">
						<div class="ocdi-install-plugins-content-header">
							<h1><?php esc_html_e( 'Rise Demo Importer', 'rise-builder' ); ?></h1>
							<p>
								<?php 
									esc_html_e( 'You do not need to build your site from scratch, RT Easy Builder provides a variety of modules to create a website. Before your begin, make sure all the required plugins are activated. When you import the data, following things might happen.', 'rise-builder' ); 
								?>
							</p>

							<ol>
								<li>
									<?php 
										esc_html_e( 'Importing the demo on the site if you have already added the content is highly discouraged.', 'rise-builder' ); 
									?>
								</li>
								<li>
									<?php 
										esc_html_e( 'Recommended installing a demo on fresh WordPress install to exactly replicate the demo.', 'rise-builder' ); 
									?>
								</li>
								<li>
									<?php
										esc_html_e( 'It will install the required plugins for installing the required theme demo within your site.', 'rise-builder' );
									?>
								</li>
								<li>
									<?php esc_html_e( 'It will take some time to import the theme demo.', 'rise-builder' ); ?>
								</li>
							</ol>

							<?php if ( ! empty( $theme_plugins['import_notice'] ) ) : ?>
								<div class="notice  notice-info">
									<p><?php echo wp_kses_post( $theme_plugins['import_notice'] ); ?></p>
								</div>
							<?php endif; ?>
						</div>
						<div class="ocdi-install-plugins-content-content">
							<?php if ( empty( $theme_plugins ) ) : ?>
								<div class="ocdi-content-notice">
									<p>
										<?php esc_html_e( 'All required/recommended plugins are already installed. You can import your demo content.' , 'rise-builder' ); ?>
									</p>
								</div>
							<?php else : ?>
								<div>
								<?php foreach ( $theme_plugins['required_plugins'] as $plugin ) : ?>
									<?php $is_plugin_active = $plugin_installer->is_plugin_active( $plugin['slug'] ); ?>
									<label class="plugin-item plugin-item-<?php echo esc_attr( $plugin['slug'] ); ?><?php echo $is_plugin_active ? ' plugin-item--active' : ''; ?><?php echo ! empty( $plugin['required'] ) ? ' plugin-item--required' : ''; ?>" for="ocdi-<?php echo esc_attr( $plugin['slug'] ); ?>-plugin">
										<div class="plugin-item-content">
											<div class="plugin-item-content-title">
												<h3><?php echo esc_html( $plugin['name'] ); ?></h3>
											</div>
											<?php if ( ! empty( $plugin['description'] ) ) : ?>
												<p>
													<?php echo wp_kses_post( $plugin['description'] ); ?>
												</p>
											<?php endif; ?>
											<div class="plugin-item-error js-ocdi-plugin-item-error"></div>
											<div class="plugin-item-info js-ocdi-plugin-item-info"></div>
										</div>
										<span class="plugin-item-checkbox">
											<input type="checkbox" id="ocdi-<?php echo esc_attr( $plugin['slug'] ); ?>-plugin" name="<?php echo esc_attr( $plugin['slug'] ); ?>" <?php checked( ! empty( $plugin['preselected'] ) || ! empty( $plugin['required'] ) || $is_plugin_active ); ?><?php disabled( $is_plugin_active ); ?>>
											<span class="checkbox">
												<img src="<?php echo esc_url( OCDI_URL . 'assets/images/icons/check-solid-white.svg' ); ?>" class="ocdi-check-icon" alt="<?php esc_attr_e( 'Checkmark icon', 'rise-builder' ); ?>">
												<?php if ( ! empty( $plugin['required'] ) ) : ?>
													<img src="<?php echo esc_url( OCDI_URL . 'assets/images/icons/lock.svg' ); ?>" class="ocdi-lock-icon" alt="<?php esc_attr_e( 'Lock icon', 'rise-builder' ); ?>">
												<?php endif; ?>
												<img src="<?php echo esc_url( OCDI_URL . 'assets/images/loader.svg' ); ?>" class="ocdi-loading ocdi-loading-md" alt="<?php esc_attr_e( 'Loading...', 'rise-builder' ); ?>">
											</span>
										</span>
									</label>
								<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="ocdi-install-plugins-content-footer">
							<a href="<?php echo esc_url( $ocdi->get_plugin_settings_url() ); ?>" class="button"><img src="<?php echo esc_url( OCDI_URL . 'assets/images/icons/long-arrow-alt-left-blue.svg' ); ?>" alt="<?php esc_attr_e( 'Back icon', 'rise-builder' ); ?>"><span><?php esc_html_e( 'Go Back' , 'rise-builder' ); ?></span></a>
							<a href="#" class="button button-primary js-ocdi-install-plugins-before-import"><?php esc_html_e( 'Continue & Import' , 'rise-builder' ); ?><span class="dashicons dashicons-image-rotate-right"></span></a>
						</div>
					</div>
				<?php else : ?>
					<div class="js-ocdi-auto-start-manual-import"></div>
				<?php endif; ?>

				<div class="ocdi-importing js-ocdi-importing">
					<div class="ocdi-importing-header">
						<h2><?php esc_html_e( 'Importing Content' , 'rise-builder' ); ?></h2>
						<p><?php esc_html_e( 'Please sit tight while we import your content. Do not refresh the page or hit the back button.' , 'rise-builder' ); ?></p>
					</div>
					<div class="ocdi-importing-content">
						<img class="ocdi-importing-content-importing" src="<?php echo esc_url( OCDI_URL . 'assets/images/importing.svg' ); ?>" alt="<?php esc_attr_e( 'Importing animation', 'rise-builder' ); ?>">
					</div>
				</div>

				<div class="ocdi-imported js-ocdi-imported">
					<div class="ocdi-imported-header">
						<h2 class="js-ocdi-ajax-response-title"><?php esc_html_e( 'Import Complete!' , 'rise-builder' ); ?></h2>
						<div class="js-ocdi-ajax-response-subtitle">
							<p>
								<?php esc_html_e( 'Congrats, your demo was imported successfully. You can now begin editing your site.' , 'rise-builder' ); ?>
							</p>
						</div>
					</div>
					<div class="ocdi-imported-content">
						<div class="ocdi__response  js-ocdi-ajax-response"></div>
					</div>
					<div class="ocdi-imported-footer">
						<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary button-hero"><?php esc_html_e( 'Theme Settings' , 'rise-builder' ); ?></a>
						<a href="<?php echo esc_url( get_home_url() ); ?>" class="button button-primary button-hero"><?php esc_html_e( 'Visit Site' , 'rise-builder' ); ?></a>
					</div>
				</div>
			</div>
			<div class="ocdi__content-container-content--side">
				<?php $importer->small_theme_card(); ?>
			</div>
		</div>

	</div>
</div>
