<?php
/**
 * Render Navigation Menu block
 *
 * @since 2.1
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Navigation_Menu' ) ){
	
	class Rise_Blocks_Navigation_Menu extends Rise_Blocks_Base{

		/**
		* Name of the block.
		*
		* @access protected
		* @since 2.1
		* @var string
		*/
		protected $slug = 'navigation-menu';

		/**
		* Title of this block.
		*
		* @access protected
		* @since 2.1
		* @var string
		*/
		protected $title = '';

		/**
		* Description of this block.
		*
		* @access protected
		* @since 2.1
		* @var string
		*/
		protected $description = '';

		/**
		* SVG Icon for this block.
		*
		* @access protected
		* @since 2.1
		* @var string
		*/
		protected $icon = '<svg 
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="76px" height="76px">
            <image  x="0px" y="0px" width="76px" height="76px"  xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEwAAABMBAMAAAA1uUwYAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAJFBMVEUAAAA3Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc////8pLxv8AAAACnRSTlMAQIC/IJ9gEDDvtD2JYgAAAAFiS0dECx/XxMAAAAAHdElNRQfjCRcMDSli3NGeAAAAl0lEQVRIx2NgEDImCFQYGFhXEQESGKSIUbaEQYsYZYsYrIaHsgUMeADXqDJ8yiA8BgZG5GBdMKqMkDImJSUlRSDNooQEFAZHnA5mZYyCgoIiQJpdEAkIDI44HQbKiAzewZxCBkQZM7AWNgPSHMjVssHgiNNhoGwwR/1gVUYQDG5lWsQp8yJG2RQGNiJUrWxgYHBSIghUGAAKpO0PWVt/UwAAAABJRU5ErkJggg==" />
        </svg>';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 2.1
        * @var string
        */
        protected $demo_link = 'rise-blocks/navigation-menu';

		/**
		* To store Array of this blocks
		*
		* @access protected
		* @since 2.1
		* @var array
		*/
		protected $blocks = array();

		/**
		* The object instance.
		*
		* @static
		* @access protected
		* @since 2.1
		* @var object
		*/
		private static $instance;

		/**
		* Constructor Function.
		*
		* @static
		* @access protected
		* @since 2.1
		* @var object
		*/
		public function __construct(){
			$this->title       = esc_html__( 'Navigation Menu', 'rise-blocks' );
			$this->description = esc_html__( 'This block allows you to customize menus easily. Tailor styles and layouts for a seamless navigation experience on your site', 'rise-blocks' );
		}

	   /**
		* Gets an instance of this object.
		* Prevents duplicate instances which avoid artefacts and improves performance.
		*
		* @static
		* @access public
		* @since 2.1
		* @return object
		*/
		public static function get_instance() {
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
						'handler' => 'hc-mobile-nav',
						'script'  => 'vendors/hc-mobile-nav/hc-offcanvas-nav.js',
						'version' => '1.0.0',
						'minified' => false,
						'dependency' => array( 'jquery' )
					),
					array(
						'handler' => 'hc-mobile-nav',
						'style'   => 'vendors/hc-mobile-nav/hc-offcanvas-nav.css',
						'version' => '6.1.3',
						'minified' => false
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
		* @since 2.1
		* @return null
		*/
		public function prepare_scripts_styles(){ 
			
			foreach( $this->blocks as $block ){

				$attrs = self::get_attrs_with_default( $block[ 'attrs' ] );

				self::add_styles(array(
					'attrs' => $attrs,
					'css'   => array(
						array(
							'selector' => '.%prefix-main-nav li a',
							'props' => array(
								'color' => 'color'
							)
						),
						array(
							'selector' => array( '.%prefix-main-nav li a:hover', '.%prefix-main-nav > li.current-menu-item > a' ),
							'props' => array(
								'color' => 'activeColor',
								'background-color' => 'activeBgColor'
							)
						),
						array(
							'selector' => array( '.%prefix-main-nav', '.%prefix-main-nav ul' ),
							'props' => array(
								'background-color' => 'bgColor'
							)
						)
					)
				));

				self::add_styles(array(
					'attrs' => $attrs,
					'css' => array(
						array(
							'selector' => array( '.%prefix-main-nav', '.%prefix-main-nav ul', '.nav-container', '.nav-wrapper' ),
							'props' => array(
								'background' => 'bgColor'
							)
						),
						array(
							'selector' => array( '.nav-item-link' ),
							'props' => array(
								'color' => 'color'
							)
						),
						array(
							'selector' => array( '.nav-close-button span::before', '.nav-close-button span::after', '.nav-next span::before' ),
							'props' => array(
								'border-top-color' => 'color',
								'border-left-color' => 'color'
							)
						),
						array(
							'selector' => array( '.%prefix-main-nav li a:hover', '.%prefix-main-nav > li.current-menu-item > .nav-item-wrapper a', 'li.menu-item-has-children.level-open', 'li.menu-item-has-children.level-open li', 'li.menu-item-has-children.level-open a', 'li.menu-item-has-children.level-open li a' ),
							'props' => array(
								'color' => 'activeColor',
								'background-color' => 'activeBgColor'
							)
						)
					),
					'wrapper_selector' => '.'
				));

				# Typography for title, content on mobile
				$typo = self::get_initial_responsive_props();
				if( isset( $attrs[ 'typo' ] ) ){
					$typo = self::get_typography_props( $attrs[ 'typo' ] );
				}

				$padding = self::get_initial_responsive_props();
				if( isset( $attrs[ 'padding' ] ) ){
					$padding = self::get_dimension_props( 'padding',
						$attrs[ 'padding' ]
					);
				}

				$menu_item_padding = self::get_initial_responsive_props();
				if( isset( $attrs[ 'menuItemPadding' ] ) ){
					$menu_item_padding = self::get_dimension_props( 'padding',
						$attrs[ 'menuItemPadding' ]
					);
				}

				$margin = self::get_initial_responsive_props();
				if( isset( $attrs[ 'margin' ] ) ){
					$margin = self::get_dimension_props( 'margin',
						$attrs[ 'margin' ]
					);
				}

				foreach( [ 'mobile', 'tablet', 'desktop' ] as $device ){
					$css = array(
						array(
							'selector' => array( 'li', 'a' ),
							'props'    => $typo[ $device ]
						),
						array(
							'selector' => '.%prefix-navigation-menu-inner-wrapper > ul > li > a',
							'props'    => $menu_item_padding[ $device ]
						),

						array(
							'selector' => '.%prefix-navigation-menu-inner-wrapper > ul',
							'props'    => array_merge( $padding[ $device ], $margin[ $device ] )
						),
					);

					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device );
				}
				ob_start();
				?>
				(function($){
					var wrapper = '#<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>';
					$( wrapper + ' .rise-blocks-navigation-menu-inner-wrapper' ).hcOffcanvasNav({
						position : 'right',
						disableAt: <?php echo esc_attr( $attrs[ 'breakpoint' ] ); ?>,
						levelOpen: 'expand',
						navClass: '<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>',
						closeActiveLevel: false
					});
				})(jQuery);
				<?php
				$js = ob_get_clean();
				self::add_scripts( $js );
			}
		}

	   /**
		* Returns attributes for this Block
		*
		* @access public
		* @since 2.1
		* @return array
		*/
		protected function get_attrs(){
			return array(

				# Hidden setting
				'block_id' => array(
					'type' => 'string',
				),
				'alignment' => array(
					'type' => 'string',
					'default' => 'right'
				),
				'typo' => array(
					'type' => 'object',
					'default' => array(
						'fontFamily' => '',
						'fontSize'   => array(
							'units' => array( 'px', 'em', 'rem' ),
							'activeUnit' => 'px',
							'values' => array(
								'desktop' => 15,
								'tablet'  => 15,
								'mobile'  => 15
							)
						),
						'fontWeight' => 400,
						'lineHeight' => array(
							'activeUnit' => '',
							'units'      => array( '' ),
							'values'     => array(
								'desktop' => 1.2,
								'tablet'  => 1.2,
								'mobile'  => 1.2
							)
						)
					)
				),
				'margin' => array(
					'type' => 'object',
					'default' => array(
						'activeUnit'   => 'px',
						'isLinkActive' => true,
						'properties'   => array( 'top', 'right', 'bottom', 'left' ),
						'responsiveViews' => array( 'desktop', 'tablet', 'mobile' ),
						'units' => array( 'px', 'rem' ),
						'values' => array(
							'desktop' => array( 0, 0, 0, 0 ),
							'tablet' => array( 0, 0, 0, 0 ),
							'mobile' => array( 0, 0, 0, 0 ),
						)  
					)
				),
				'padding' => array(
					'type' => 'object',
					'default' => array(
						'activeUnit'   => 'px',
						'isLinkActive' => true,
						'properties'   => array( 'top', 'right', 'bottom', 'left' ),
						'responsiveViews' => array( 'desktop', 'tablet', 'mobile' ),
						'units' => array( 'px' ),
						'values' => array(
							'desktop' => array( 15, 15, 15, 15 ),
							'tablet' => array( 15, 15, 15, 15 ),
							'mobile' => array( 15, 15, 15, 15 ),
						)
					)
				),
				'menuItemPadding' => array(
					'type' => 'object',
					'default' => array(
						'activeUnit'   => 'px',
						'isLinkActive' => false,
						'properties'   => array( 'top', 'right', 'bottom', 'left' ),
						'responsiveViews' => array( 'desktop', 'tablet', 'mobile' ),
						'units' => array( 'px', 'rem' ),
						'values' => array(
							'desktop' => array( 10, 15, 10, 15 ),
							'tablet' => array( 10, 15, 10, 15 ),
							'mobile' => array( 10, 15, 10, 15 ),
						)
					)
				),
				'selectedMenu' => array(
					'type' => 'string',
					'default' => "0"
				),
				'color' => array(
					'type' => 'string',
					'default' => '#000000'
				),
				'bgColor' => array(
					'type' => 'string',
					'default' => '#eeeeee'
				),
				'activeColor' => array(
					'type' => 'string',
					'default' => '#ffffff'
				),
				'activeBgColor' => array(
					'type' => 'string',
					'default' => '#000000'
				),
				'breakpoint' => array(
					'type'    => 'string',
					'default' => 920
				)
			);
		}

	   /**
		* Renders blocks in frontend
		*
		* @access public
		* @since 2.1
		* @return string
		*/
		public function render( $attrs, $content ){
			
			$block_content = '';
			ob_start();
			$container_class = 'align-' . $attrs[ 'alignment' ] . self::add_prefix( ' %prefix-navigation-menu-wrapper' );
			?>
			<div id="<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>" class="<?php echo esc_attr( $container_class ); ?>">
				<div class="<?php echo esc_attr( self::add_prefix( '%prefix-navigation-menu-inner-wrapper' ) ); ?>">
					<?php
						$args = apply_filters( self::add_prefix( '%prefix-navigation-menu' ), array(
							'menu'            => $attrs[ 'selectedMenu' ],
							'container'       => '',
							'menu_id'         => $attrs[ 'block_id' ] . '-menu',
							'menu_class'      => self::add_prefix( '%prefix-main-nav' ) . ' menu',
							'echo'            => true
						), $attrs );

						wp_nav_menu( $args );
					?>
				</div>
			</div>
			<?php
			$block_content = ob_get_clean();
			return $block_content;
		}
	}
}

Rise_Blocks_Navigation_Menu::get_instance()->init();