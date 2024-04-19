<?php
namespace RT_Easy_Builder;

class Plugin_Page extends Builder{

	public $menu_slug = 'rt-easy-builder';

	public function __construct(){
		add_action( 'admin_menu', array( $this, 'create_plugin_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'admin_head', array( $this, 'load_fonts' ) );
	}

	public function create_plugin_page() {

		$args = array(
			'parent_slug' => 'themes.php',
			'page_title'  => esc_html__( 'RT Easy Builder', 'rise-builder' ),
			'menu_title'  => esc_html__( 'RT Easy Builder', 'rise-builder' ),
			'capability'  => 'manage_options',
			'menu_slug'   => $this->menu_slug,
		);

		add_menu_page(
		    $args[ 'page_title' ],
		    $args[ 'page_title' ],
		    $args[ 'capability' ],
		    $this->menu_slug,
		    array( $this, 'display_plugin_page' ),
		    '',
		    110
		);
	}

	public function load_fonts(){
		if( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == $this->menu_slug ):
		?>
			<link rel="preconnect" href="<?php echo esc_url( '//fonts.gstatic.com' ); ?>">
		<?php
		endif;
	}

	public function display_plugin_page(){
		$elementor = $this->get_module( 'elementor' );
		$this->require( 'modules/plugin-page/views/page.php', array( 'widgets' => $elementor::$widget_instances ) );
	}

	public function scripts( $hook ){
		if ( 'toplevel_page_' . $this->menu_slug === $hook ) {
			$script = $this->get_module( 'script-handler' );
			$script->enqueue(array(
				'handler' => 'plugin-page',
				'file'    => 'modules/plugin-page/assets/style.css'
			), false);

			$script->enqueue(array(
				'handler' => 'plugin-page-google-fonts',
				'file'    => '//fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap',
				'absolute' => true
			));
		}
	}
}