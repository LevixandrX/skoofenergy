<?php
/**
 * Importer
 *
 * @since 1.0
 */
namespace RT_Easy_Builder;

class Importer extends Builder{

	public $ocdi_zip   = 'https://downloads.wordpress.org/plugin/one-click-demo-import.zip';
	public $ocdi_path  = 'one-click-demo-import/one-click-demo-import.php';
	public $menu_slug  = 'one-click-demo-import';

	public $menu_title;
	public $installer;

	public function __construct(){

		$this->menu_title = esc_html__( 'Rise Demo Importer', 'rise-builder' );
		$this->installer = new Plugin_Installer( array(
			'path' => $this->ocdi_path,
			'zip'  => $this->ocdi_zip
		));

		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'wp_ajax_activate_plugins', array( $this, 'ajax_activate_plugins' ) );
		
		if( $this->installer->is_activated() ){
			add_filter( 'ocdi/plugin_page_setup', array( $this, 'menu_title' ) );
			add_filter( 'ocdi/import_files', array( $this, 'get_import_files' ) );

			add_filter( 'pt-ocdi/plugin_page_display_callback_function', array( $this, 'plugin_page' ) );
			add_action( 'pt-ocdi/after_import', array( $this, 'after_import_setup' ) );
		}else{
			add_action( 'admin_menu', array( $this, 'create_plugin_page' ) );
		}

	}

	public function menu_title( $menu ){
		$menu[ 'menu_title' ] = $this->menu_title;
		return $menu;
	}

	public function ajax_response_error( $msg ){
		?>
		<div id="response-error">
			<span class="message"><?php echo esc_html( $msg ); ?></span>
		</div>
		<?php
	}

	public function ajax_activate_plugins(){

		check_ajax_referer( 'rt-easybuilder-ajax-nonce', 'security' );
		if ( ! current_user_can( 'manage_options' ) ){
			$this->ajax_response_error(
				__( 'You are not allowed perform this action.', 'rise-builder' )
			);
			wp_die();
		}

		if( $this->installer->is_installed() ){
			$this->installer->upgrade();
			$installed = true;
		}else{
			$installed = $this->installer->install();
		}
   
	    if( !is_wp_error( $installed ) && $installed ){
		    activate_plugin( $this->ocdi_path );
		    $url = add_query_arg( array( 'page' => $this->menu_slug ), admin_url( 'admin.php' ) );
		    ?>
		    <div id="response-success">
		    	<span class="redirect-url"><?php echo esc_url( $url ); ?></span>
		    </div>
		    <?php
		}else {
			$this->ajax_response_error(
				__( 'Something went wrong.', 'rise-builder' )
			);
			wp_die();
		}
	}

	/**
	 * Creates the plugin page and a submenu item in WP Appearance menu.
	 */
	public function create_plugin_page() {

		$args = apply_filters( 'pt-ocdi/plugin_page_setup', array(
			'parent_slug' => 'themes.php',
			'page_title'  => esc_html__( 'Rise Demo Importer', 'rise-builder' ),
			'menu_title'  => $this->menu_title,
			'capability'  => 'import',
			'menu_slug'   => $this->menu_slug,
		));

		add_submenu_page(
			$args['parent_slug'],
			$args['page_title'],
			$args['menu_title'],
			$args['capability'],
			$args['menu_slug'],
			array( $this, 'display_plugin_page' )
		);
	}

	public function display_plugin_page(){
		$this->require( 'modules/importer/views/wizard-page.php' );
	}

	public function scripts( $hook ){
	
		if ( 'appearance_page_' . $this->menu_slug === $hook ) {

			$script = $this->get_module( 'script-handler' );
			$script->enqueue(array(
				'handler'    => 'importer',
				'file'       => 'modules/importer/assets/style.css'
			), false);

			$i18n = array(
				'ajaxurl' =>  admin_url( 'admin-ajax.php' ),
				'rest'    => rest_url(),
				'nonce'   => wp_create_nonce( "rt-easybuilder-ajax-nonce" )
			);

			$script->enqueue(array(
				'handler'  => 'importer',
				'file'     => 'modules/importer/assets/script.js',
				'localize' => array(
					'name' => 'RTEASYBUILDER',
					'data' => $i18n
				)
				
			), false);
		}
		
	}

	public function get_import_files(){

		$contents  = array();
		// $site_url  = "https://risethemes.com/demo-contents/";
		$site_url  = "https://www.eaglevisionit.com/demo-contents/";
		$demo_json = $site_url . "demos.json";

		$handle = @fopen($demo_json, 'r');
		if(!$handle){
		    return $contents;
		}

		$demos = @file_get_contents( $demo_json );

		if( !$demos )
			return $contents;

		$demos = json_decode( $demos, true ); 
		if( $demos && isset( $demos[ 'demos' ] ) && is_array( $demos[ 'demos' ] ) ){
			foreach( $demos[ 'demos' ] as $demo ){

				$path = $site_url . $demo[ "directory" ];
				$contents[] = array(
					'import_file_name'           => $demo[ 'name' ],
					'categories'                 => $demo[ 'categories' ],
					'pro'                        => isset( $demo[ 'is_pro' ] ) ? $demo[ 'is_pro' ] : false,
					'import_preview_image_url'   => $path . '/screenshot.png',
					'import_file_url'            => $path . '/wordpress.xml',
					'import_widget_file_url'     => $path . '/widget.wie',
					'import_customizer_file_url' => $path . '/customizer.dat',
					'import_notice'              => $demo[ 'notice' ],
					'preview_url'                => isset( $demo[ "preview_url" ] ) ? $demo[ 'preview_url' ] : '#',
					'theme'                      => $demo[ 'theme' ],
					'required_plugins'           => isset( $demo['required_plugins'] ) ? $demo[ 'required_plugins' ] : ''
				);
			}
		}

		return $contents;
	}

	public function small_theme_card(){

		$selected   = isset( $_GET['import'] ) ? (int) $_GET['import'] : null;
		$theme      = wp_get_theme();
		$screenshot = $theme->get_screenshot();
		$name       = $theme->name;

		$import_files = $this->get_import_files();
		if ( isset( $selected ) && isset( $import_files[ $selected ] ) ) {
			$selected_data = $import_files;
			$name          = ! empty( $selected_data['import_file_name'] ) ? $selected_data['import_file_name'] : $name;
			$screenshot    = ! empty( $selected_data['import_preview_image_url'] ) ? $selected_data['import_preview_image_url'] : $screenshot;
		}

		?>
		<div class="ocdi__card ocdi__card--theme">
			<div class="ocdi__card-content">
				<?php if ( $screenshot ) : ?>
					<div class="screenshot">
						<img src="<?php echo esc_url( $screenshot ); ?>" 
							alt="<?php esc_attr_e( 'Theme screenshot', 'rise-builder' ); ?>" />
					</div>
				<?php else : ?>
					<div class="screenshot blank"></div>
				<?php endif; ?>
			</div>
			<div class="ocdi__card-footer">
				<h3><?php echo esc_html( $name ); ?></h3>
			</div>
		</div>
		<?php
	}

	public function after_import_setup() {

	    // Assign menus to their locations.
	    $locations = array( 'primary' => 'primary', 'social-menu-footer' => 'social' );
	    $new = get_theme_mod( 'nav_menu_locations' );
	    foreach( $locations as $loc => $name ){

		    $menu = get_term_by( 'name', $name, 'nav_menu' );
		    if( $menu ){
		    	$new[ $loc ] = $menu->term_id;
		    }
	    }

	    set_theme_mod( 'nav_menu_locations', $new );

	    // Assign front page and posts page (blog page).
	    $front_page_id = get_page_by_title( 'Front Page' );
	    $blog_page_id  = get_page_by_title( 'Blog' );

	    update_option( 'show_on_front', 'page' );
	    if( $front_page_id ){
	    	update_option( 'page_on_front', $front_page_id->ID );
	    }

	    if( $blog_page_id ){
	    	update_option( 'page_for_posts', $blog_page_id->ID );
	    }

	}

	public function plugin_page( $d ){ 
		return array( $this, 'content' );
	}

	public function content(){
		
		if ( isset( $_GET['step'] ) && 'import' === $_GET['step'] ) {
			$this->require( 'modules/importer/views/ocdi-import.php' );
			return;
		}

		$this->require( 'modules/importer/views/ocdi-page.php' );
	}
}
