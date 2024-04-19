<?php 
if( !class_exists( 'Rise_Blocks_Marketplace' ) ){
	class Rise_Blocks_Marketplace extends Rise_Blocks_Helper{

		public $parent_slug = 'rise_blocks';

		public $page_slug = 'rise-blocks-marketplace';

		public function __construct(){
			add_action( 'admin_menu', array( $this, 'add_submenu' ), 90 );
			if( isset( $_REQUEST['page'] ) && $this->page_slug == $_REQUEST['page'] ){
				add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
			}
		}

		public function add_submenu(){
			add_submenu_page(
			    $this->parent_slug, # parent slug
			    esc_html__( 'Marketplace', 'rise-blocks' ), # page title
			    esc_html__( 'Marketplace', 'rise-blocks' ), # menu title
			    'manage_options', # capability
			    $this->page_slug, # menu_slug
			    array( $this, 'render' ), # function
			    20 # position
			);
		}

        public static function scripts() {
			$scripts = array(
                array(
                    'handler'  => self::add_prefix( '%prefix-marketplace-css' ),
                    'style'    => 'classes/marketplace/style.css',
                    'minified' => false
                )
            );
			self::enqueue( $scripts );
		}

		public function render(){
			require_once plugin_dir_path( Rise_Blocks_File ) . 'classes/marketplace/template.php';
		}
	}

	//new Rise_Blocks_Marketplace();
}