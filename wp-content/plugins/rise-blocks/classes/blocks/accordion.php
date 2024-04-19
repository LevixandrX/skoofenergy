<?php
/**
 * Render Accordion block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Accordion' ) ){
	
	class Rise_Blocks_Accordion extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'accordion';

		/**
		* Title of this block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $title = '';

		/**
		* Description of this block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $description = '';

		/**
		* SVG Icon for this block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $icon = '<svg height="60px" width="60px"  fill="#436DD3" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 110 110" enable-background="new 0 0 110 110" xml:space="preserve"><g><path d="M7,6v16v4v12v4v42v4v16h96V88v-4V42v-4V26v-4V6H7z M99,100H11V88h88V100z M99,84H11V42h88V84z M99,38H11V26h88V38z M11,22   V10h88v12H11z"></path><polygon points="13,20 21,16 13,12  "></polygon><polygon points="21,28 13,28 17,36  "></polygon><polygon points="13,90 13,98 21,94  "></polygon></g></svg>';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.0
        * @var string
        */
        protected $demo_link = 'rise-blocks/accordion';
		/**
		* To store Array of this blocks that user adds
		*
		* @access protected
		* @since 1.0.0
		* @var array
		*/
		protected $blocks = array();

		/**
		* The object instance.
		*
		* @static
		* @access protected
		* @since 1.0.0
		* @var object
		*/
		private static $instance;

		/**
		* Constructor Function.
		*
		* @static
		* @access protected
		* @since 1.0.0
		* @var object
		*/
		public function __construct(){
			$this->title       = esc_html__( 'Accordion', 'rise-blocks' );
			$this->description = esc_html__( 'This block allows you to add collapsible content/faqs on a page or post. It helps for reducing scrolling and categorizing information.', 'rise-blocks' );
		}

	   /**
		* Gets an instance of this object.
		* Prevents duplicate instances which avoid artefacts and improves performance.
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return object
		*/
		public static function get_instance(){
			if ( ! self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

	   /**
		* Enqueue Frontend Scripts and Styles
		* Called in wp_enqueue_scripts hook
		* Fires in frontend
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public function enqueue_scripts_styles(){

			$this->get_blocks();
			if( count( $this->blocks ) > 0 ){

				$scripts = array(
					array(
						'handler' => 'jquery-ui-core',
						'script'  => true,
					),
					array(
						'handler' => 'jquery-ui-accordion',
						'script'  => true,
					),
					array(
						'handler' => 'jquery-ui-css',
						# https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css
						'style' => 'vendors/jquery-ui-base.css'
					)
				);

				$scripts = apply_filters( self::get_block_name( $this->slug ) . '_frontend_assets', $scripts, $this );
				self::enqueue( $scripts );
			}
		}

	   /**
		* Generate & Print Frontend Styles
		* Called in wp_head hook
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public function prepare_scripts_styles(){
			
			ob_start();
			foreach( $this->blocks as $block ){
				
                $attrs = $block[ 'attrs' ];
                ?>
                var $ele = jQuery( "#<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>" );
                if( $ele.length > 0 ){
                    $ele.accordion({
                        active: false,
                        collapsible: true,
                        heightStyle: "content",
                        header: 'div.rise-blocks-accordion-item  > .rise-blocks-accordion-item-header',
                        beforeActivate: function(event, ui){
                            var active = !jQuery( event.currentTarget ).hasClass( 'ui-state-active' );
                            
                            var $ps = jQuery( '#<?php echo esc_attr( $attrs[ 'block_id' ] ); ?> .rise-blocks-page-slider-overlay' );
                            var $cp = jQuery( '#<?php echo esc_attr( $attrs[ 'block_id' ] ); ?> .rise-blocks-carousel-post-overlay' );

                            if( active ){
                                $ps.show();
                                $cp.show();
                            }
                        },
                        activate: function( event, ui ){
                            var $ps = jQuery( '#<?php echo esc_attr( $attrs[ 'block_id' ] ); ?> .rise-blocks-page-slider-overlay' );
                            var $cp = jQuery( '#<?php echo esc_attr( $attrs[ 'block_id' ] ); ?> .rise-blocks-carousel-post-overlay' );
                            
                            var $ele = jQuery('#<?php echo esc_attr( $attrs[ 'block_id' ] ); ?> .news2-init');
                            if( $ele.length > 0 ){
                                $ele.slick( 'refresh' );
                            }

                            setTimeout(function(){
                                $ps.hide();
                                $cp.hide();	
                            }, 100);
                        }
                    });
                }
                <?php
			}

			$js = ob_get_clean();
			self::add_scripts( $js );
		}
	}
}

Rise_Blocks_Accordion::get_instance()->init();
