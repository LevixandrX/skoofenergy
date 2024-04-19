<?php
/**
 * Render Site Identity block
 *
 * @since 2.1
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Section_Identity' ) ){
	
	class Rise_Blocks_Section_Identity extends Rise_Blocks_Base{

		/**
		* Name of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'site-identity';

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
        * @since 1.0.0
        * @var string
        */
        protected $demo_link = 'rise-blocks/site-identity';

		/**
		* To store Array of this blocks
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
			$this->title       = esc_html__( 'Site Identity', 'rise-blocks' );
			$this->description = esc_html__( 'These block empowers you to effortlessly manage and customize your site\'s title, tagline, and logo appearance.', 'rise-blocks' );
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
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

	   /**
		* Generate & Print Frontend Styles
		* Called in wp_head hook
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public function prepare_scripts_styles(){ 

			$this->get_blocks();
			
			foreach( $this->blocks as $block ){

				$attrs = self::get_attrs_with_default( $block[ 'attrs' ] );

				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => array(
						array(
							'selector' => '.%prefix-site-title img',
							'props' => array(
								'height' => array( 'unit' => 'px', 'value' => $attrs[ 'height' ] ),
								'width'  => array( 'unit' => 'px', 'value' => $attrs[ 'width' ] )
							)
						),
					),
				));

				# Typography for title, content on mobile
				$title_typo = self::get_initial_responsive_props();
				if( isset( $attrs[ 'titleTypo' ] ) ){
					$title_typo = self::get_typography_props( $attrs[ 'titleTypo' ] );
				}

				$tagline_typo = self::get_initial_responsive_props();
				if( isset( $attrs[ 'taglineTypo' ] ) ){
					$tagline_typo = self::get_typography_props( $attrs[ 'taglineTypo' ] );
				}

				$padding = self::get_initial_responsive_props();
				if( isset( $attrs[ 'padding' ] ) ){
					$padding = self::get_dimension_props( 'padding',
						$attrs[ 'padding' ]
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
							'selector' => array( '.%prefix-site-title', '.%prefix-site-title > a' ),
							'props'    => $title_typo[ $device ]
						),
						array(
							'selector' => '.%prefix-site-description',
							'props'    => $tagline_typo[ $device ]
						),
						array(
							'selector' => '',
							'props'    => array_merge( $padding[ $device ], $margin[ $device ] )
						),
					);

					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device );
				}

				$dynamic_css = array(
					array(
						'selector' => array( '.%prefix-site-title', '.%prefix-site-title a' ),
						'props' => array(
							'color' => 'titleColor'
						)
					),
					array(
						'selector' => array( '.%prefix-site-description a', '.%prefix-site-description' ),
						'props' => array(
							'color' => 'taglineColor'
						)
					)
				);

				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => $dynamic_css
				));
			}
		}

	   /**
		* Returns attributes for this Block
		*
		* @access public
		* @since 1.0.0
		* @return array
		*/
		protected function get_attrs(){
			return array(

				# Hidden setting
				'block_id' => array(
					'type' => 'string',
				),
				'titleTypo' => array(
					'type' => 'object',
					'default' => array(
						'fontFamily' => '',
						'fontSize'   => array(
							'units' => array( 'px', 'em', 'rem' ),
							'activeUnit' => 'px',
							'values' => array(
								'desktop' => 32,
								'tablet'  => 22,
								'mobile'  => 18
							)
						),
						'fontWeight' => 600,
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
				'taglineTypo' => array(
					'type' => 'object',
					'default' => array(
						'fontFamily' => '',
						'fontSize'   => array(
							'units' => array( 'px', 'em', 'rem' ),
							'activeUnit' => 'px',
							'values' => array(
								'desktop' => 14,
								'tablet'  => 12,
								'mobile'  => 10
							)
						),
						'fontWeight' => 400,
						'lineHeight' => array(
							'activeUnit' => '',
							'units'      => array( '' ),
							'values'     => array(
								'desktop' => 1.8,
								'tablet'  => 1.8,
								'mobile'  => 1.8
							)
						)
					)
				),
				'logoTag' => array(
					'type' => 'string',
					'default' => 'h1'
				),
				'titleTag' => array(
					'type' => 'string',
					'default' => 'div'
				),
				'taglineTag' => array(
					'type' => 'string',
					'default' => 'p'
				),
				'titleColor' => array(
					'type' => 'string',
					'default' => '#000000'
				),
				'taglineColor' => array(
					'type' => 'string',
					'default' => '#000000'
				),
				'logo' => array(
					'type' => 'object',
					'default' => array(
						'sizes' => 'full',
						'url' => false
					)
				),
				'enableSiteTitle' => array(
					'type' => 'boolean',
					'default' => true
				),
				'enableTagline' => array(
					'type' => 'boolean',
					'default' => true
				),
				'padding' => array(
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
				'height' => array(
					'type' => 'number',
					'default' => 100
				),
				'width' => array(
					'type' => 'number',
					'default' => 300
				)
			);
		}

	   /**
		* Renders blocks in frontend
		*
		* @access public
		* @since 1.0.0
		* @return string
		*/
		public function render( $attrs, $content ){
			
			$block_content = '';
			ob_start();
			?>
			<div id="<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>">
				<div class="<?php self::add_prefix_e( '%prefix-site-branding' ); ?>">
					<?php if( $attrs[ 'logo' ][ 'url' ] != '' ): $s = $attrs[ 'logo' ][ 'size' ]; ?>
						<div class="<?php self::add_prefix_e( '%prefix-site-identity-logo' ); ?>">
							<<?php echo esc_attr( $attrs[ 'logoTag' ] ); ?>>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
									<span class="screen-reader-text"><?php esc_html_e( 'Site Logo', 'rise-blocks' ); ?></span>
									<img src="<?php echo esc_url( $attrs[ 'logo' ][ 'sizes' ][ $s ][ 'url' ] ); ?>" alt="<?php esc_attr_e( 'Site Logo', 'rise-blocks' ); ?>">
								</a>
							</<?php echo esc_attr( $attrs[ 'logoTag' ] ); ?>>
						</div>
					<?php endif; ?>

					<?php 
						if( $attrs[ 'enableSiteTitle' ] == 1 ){
							echo '<'. esc_attr( $attrs[ 'titleTag' ] ) . ' class="rise-blocks-site-title"><a href="'. home_url( '/' ). '">' . get_bloginfo( 'name', 'display' ) . '</a></'. esc_attr( $attrs[ 'titleTag' ] ) .'>';
						}

						if( $attrs[ 'enableTagline' ] == 1 ){
							echo '<'. esc_attr( $attrs[ 'taglineTag' ] ) .' class="rise-blocks-site-description">' . get_bloginfo( 'description', 'display' ) . '</' . esc_attr( $attrs[ 'taglineTag' ] ) . '>';
						}
					?>
				</div>
			</div>
			<?php
			$block_content = ob_get_clean();
			return $block_content;
		}
	}
}

Rise_Blocks_Section_Identity::get_instance()->init();