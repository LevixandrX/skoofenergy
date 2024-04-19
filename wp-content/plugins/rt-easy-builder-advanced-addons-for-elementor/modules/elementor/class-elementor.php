<?php
/**
 * Initialize Elementor custom widgets
 *
 * @since 1.0
 */
namespace RT_Easy_Builder;

class Elementor extends Builder{

	public $widget_category = array(
		'slug'  => 'rt-widgets',
		'title' => 'RT Widgets',
		'icon'  => 'fa fa-plug',
	);

	public $elementor_zip  = 'https://downloads.wordpress.org/plugin/elementor.zip';
	public $elementor_path = 'elementor/elementor.php';

	public static $widget_instances = array();

	public $installer;

	public function __construct(){

		$this->installer = new Plugin_Installer(array(
			'path' => $this->elementor_path,
			'zip'  => $this->elementor_zip
		));

		//load base widget first
		add_action( 'init', array( $this, 'load_base_widget' ), 5 );

		add_action( 'init', array( $this, 'require_widget_fields' ), 10 );
		
		//load other widgets after base, keep priority gap to 5 so that other plugin can takeover
		add_action( 'init', array( $this, 'load_custom_widgets' ), 10 );

		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ));
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ));

		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'common_scripts' ) );
		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'common_scripts' ) );
	}

	public function common_scripts(){

		$script = $this->get_module( 'script-handler' );

		$script->enqueue(array(
			'handler' => 'font-awesome',
			'file'    => 'vendors/font-awesome/css/font-awesome.min.css',
		), false);
	}

	public function get_elementor_widgets_slug(){

		$widgets = array();
		$dir = RT_EASY_BUILDER_PATH . "modules/elementor/widgets/*";

		$dirs = array_filter( glob( $dir ), 'is_dir' );
		foreach( $dirs as $dir ){
			$a         = explode( '/', $dir );
			$index     = count( $a );
			$widgets[] = $a[ $index - 1 ];
		} 

		return apply_filters( 'rt_easy_builder_elementor_widgets', $widgets );
	}

	public function require_widget_fields(){
		
		$files = RT_EASY_BUILDER_PATH . "modules/elementor/fields/*";
		foreach( glob( $files ) as $f ){
			$a     = explode( '/', $f );
			$index = count( $a );
			$this->require( "modules/elementor/fields/{$a[ $index - 1 ]}" );
		}
	}

	public function load_base_widget(){
		if( class_exists( '\Elementor\Widget_Base' ) ){
			$this->require( "modules/elementor/widgets/class-widgets.php" );
		}
	}

	public function load_custom_widgets(){
		
		if( class_exists( '\Elementor\Widget_Base' ) ){

			$widgets = $this->get_elementor_widgets_slug(); 
			foreach( $widgets as $slug ){
				
				$class = $this->get_class_name( $slug );
				if( !class_exists( $class ) ){
					$this->require( "modules/elementor/widgets/{$slug}/class-{$slug}.php" );
				}

				self::$widget_instances[ $slug ] = new $class();
			}
		}
	}

	public function register_widgets( $widgets_manager ){
		foreach( self::$widget_instances as $widget_instance ){
			$widgets_manager->register( $widget_instance );
		}
	}

	public function register_category( $elements_manager ) {
		$elements_manager->add_category(
			$this->widget_category[ 'slug' ], array(
				'title' => $this->widget_category[ 'title' ],
				'icon'  => $this->widget_category[ 'icon' ]
			)
		);
	}
}
