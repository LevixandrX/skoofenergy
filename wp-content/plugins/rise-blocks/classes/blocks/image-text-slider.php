<?php
/**
 * Render Call to action block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Image_Text_Slider' ) ){
	
	class Rise_Blocks_Image_Text_Slider extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'image-text-slider';

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
            width="60px" height="60px">
            <image  x="0px" y="0px" width="60px" height="60px"  xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFQAAABUBAMAAADuRQ3yAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAALVBMVEUAAAA3Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc/////kj7GkAAAADXRSTlMAMM/vYCCAv48Qn0BQxbT5RgAAAAFiS0dEDm+9ME8AAAAHdElNRQfjCRcLOTsvAEWkAAABH0lEQVRIx+3XPQ6CMBQH8JL4BS5EZg/A4MABSEicuYOTLu5O3oF4Ai7gYfzCBHx3kUKL9LWROviV9C0E8sufV2ghJRPQq1NEZpoULkRXQvY2el1216qmGemugaGGGvrndLRpqosOH5+Tj9O5K9NdqqI9CCRqz3IVjeHkVrSgZ9uK7gBSmfbKnABRu/z65zKNFZTsgcW2KQ2VG3CAxbYpC0W0iW1RHoopj23RaXnpQGRKj7AQaNMUovRux0TslTeFKB2Cj4bFY0XKQ8XnymJFykNFSmML/LZCFormQBkb4VSPhSLqwLnu9UhXS1hRK6xD8XzdR/J89Xzl1B4rVoGV/OYyfFaGGmroH9IX9gVf3sOEuvRW/Rm0KiV9jfHTWpM7KwMKbWMBTCoAAAAASUVORK5CYII=" />
        </svg>';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.0
        * @var string
        */
        protected $demo_link = 'rise-blocks/image-text-slider';

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
			$this->title       = esc_html__( 'Image Text Slider', 'rise-blocks' );
			$this->description = esc_html__( 'Image Text Slider enables multiple images for the slider including content like heading and description.', 'rise-blocks' );
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
						'handler' => 'slick',
						'script'  => 'vendors/slick/slick.js',
						'version' => '1.8.1',
						'dependency' => array( 'jquery' )
					),
					array(
						'handler' => 'slick',
						'style' => 'vendors/slick/slick.css',
						'version' => '1.8.1',
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
			
			foreach( $this->blocks as $block ){
				 
				$attrs = self::get_attrs_with_default( $block[ 'attrs' ] );

				$height = self::get_initial_responsive_props();
				if( isset( $attrs[ 'height' ] ) ){
					$height = self::get_responsive_props( $attrs[ 'height' ], 'height' );
				}

				$width = self::get_initial_responsive_props();
				if( isset( $attrs[ 'width' ] ) ){
					$width = self::get_responsive_props( $attrs[ 'width' ], 'width' );
				}

				$title_typography = self::get_initial_responsive_props();
				if( isset( $attrs[ 'titleTypo' ] ) ){
					$title_typography = self::get_typography_props( $attrs[ 'titleTypo' ] );
				}

				$content_typography = self::get_initial_responsive_props();
				if( isset( $attrs[ 'contentTypo' ] ) ){
					$content_typography = self::get_typography_props( $attrs[ 'contentTypo' ] );
				}

				$title_padding = self::get_initial_responsive_props();
				if( isset( $attrs[ 'titlePadding' ] ) ){
					$title_padding = self::get_dimension_props( 'padding',
						$attrs[ 'titlePadding' ]
					);
				}

				$content_padding = self::get_initial_responsive_props();
				if( isset( $attrs[ 'contentPadding' ] ) ){
					$content_padding = self::get_dimension_props( 'padding',
						$attrs[ 'contentPadding' ]
					);
				}

				self::add_styles(array(
					'attrs' => $attrs,
					'css'   => array(
						array(
							'selector' => '.title',
							'props'    => array( 'color' => 'titleColor' )
						),
						array(
							'selector' => '.content',
							'props'    => array( 'color' => 'contentColor' )
						)
					)
				), 'desktop' );

				foreach( [ 'mobile', 'tablet', 'desktop' ] as $device ){
					$css = array(
						array(
							'selector' => '.title',
							'props' => array_merge( $title_typography[ $device ], $title_padding[ $device ] )
						),
						array(
							'selector' => '.content',
							'props' => array_merge( $content_typography[ $device ], $content_padding[ $device ] )
						)
					);

					if( $attrs[ 'enableHeight' ] ){
						$css[] = array(
							'selector' => '.slick-slide .image-slider img',
							'props' => $height[ $device ]
						);
					}

					if( $attrs[ 'enableWidth' ] ){
						$css[] = array(
							'selector' => '.slick-slide .image-slider img',
							'props' => $width[ $device ]
						);
					}

					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device );
				}
				
				ob_start();
				?>
				
				var riseBlocksNewsArgs = {
					slidesToShow: 1,
					slidesToScroll: 1,
					autoplay: <?php echo $attrs[ 'enableAutoPlay' ] == true ? 'true' : 'false'; ?>,
					infinite: true,
					arrows: <?php echo $attrs[ 'enableArrows' ] == true ? 'true' : 'false'; ?>,
					dots: <?php echo $attrs[ 'enableDots' ] == true ? 'true' : 'false'; ?>,
					prevArrow: '<button type="button" class="<?php self::add_prefix_e( '%prefix-prev-arrow %prefix-slider-arrow' ); ?>"><i class="fa fa-angle-left"></i></button>',
					nextArrow: '<button type="button" class="<?php self::add_prefix_e( '%prefix-next-arrow %prefix-slider-arrow' ); ?>"><i class="fa fa-angle-right"></i></button>',
				};
				jQuery('#<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>').slick( riseBlocksNewsArgs );

				<?php
				$js = ob_get_clean();
				self::add_scripts( $js );
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
				'image' => array(
					'type' => 'array'
				),
				# Post Setting
				'enableAutoPlay' => array(
					'type' => 'boolean',
					'default' => false
				),
				'enableArrows' => array(
					'type' => 'boolean',
					'default' => false
				),
				'enableDots' => array(
					'type' => 'boolean',
					'default' => false
				),
				'height' => array(
					'type' => 'object',
					'default' => array(
						'activeUnit' => 'px',
						'units' => ['px'],
						'range' => array(
							'min' => 100,
							'max' => 1000
						),
						'values' => array(
							'desktop' => 250,
							'tablet'  => 250,
							'mobile'  => 250
						)
					)
				),
				'width' => array(
					'type' => 'object',
					'default' => array(
						'activeUnit' => 'px',
						'units' => ['px'],
						'range' => array(
							'min' => 50,
							'max' => 2000
						),
						'values' => array(
							'desktop' => 250,
							'tablet'  => 250,
							'mobile'  => 250
						)
					)
				),
				'titleTypo' => array(
					'type' => 'object',
					'default' => array(
						'fontFamily' => 'Montserrat',
						'fontSize'   => array(
							'units' => array( 'px', 'em', 'rem' ),
							'activeUnit' => 'px',
							'values' => array(
								'desktop' => 30,
								'tablet'  => 30,
								'mobile'  => 30
							)
						),
						'textTransform' => 'uppercase',
						'fontWeight' => 800,
						'lineHeight' => array(
							'activeUnit' => '',
							'units'      => array( '' ),
							'values'     => array(
								'desktop' => '1.2',
								'tablet'  => '1.2',
								'mobile'  => '1.2'
							)
						)
					)
				),
				'contentTypo' => array(
					'type' => 'object',
					'default' => array(
						'fontFamily' => 'Montserrat',
						'fontSize'   => array(
							'units' => array( 'px', 'em', 'rem' ),
							'activeUnit' => 'px',
							'values' => array(
								'desktop' => 16,
								'tablet'  => 16,
								'mobile'  => 16
							)
						),
						'textTransform' => 'initial',
						'fontWeight' => 400,
						'lineHeight' => array(
							'activeUnit' => '',
							'units'      => array( '' ),
							'values'     => array(
								'desktop' => '1.2',
								'tablet'  => '1.2',
								'mobile'  => '1.2'
							)
						)
					)
				),
				'titlePadding' => array(
					'type' => 'object',
					'default' => array(
						'activeUnit'   => 'px',
						'isLinkActive' => false,
						'properties'   => array( 'top', 'right', 'bottom', 'left' ),
						'responsiveViews' => array( 'desktop', 'tablet', 'mobile' ),
						'units' => array( 'px', 'rem' ),
						'values' => array(
							'desktop' => array( 0, 15, 15, 0 ),
							'tablet' => array( 0, 15, 15, 0 ),
							'mobile' => array( 0, 15, 15, 0 ),
						)  
					)
				),
				'contentPadding' => array(
					'type' => 'object',
					'default' => array(
						'activeUnit'   => 'px',
						'isLinkActive' => false,
						'properties'   => array( 'top', 'right', 'bottom', 'left' ),
						'responsiveViews' => array( 'desktop', 'tablet', 'mobile' ),
						'units' => array( 'px', 'rem' ),
						'values' => array(
							'desktop' => array( 0, 50, 0, 0 ),
							'tablet' => array( 0, 50, 0, 0 ),
							'mobile' => array( 0, 50, 0, 0 ),
						)  
					)
				),
				'effect' => array(
					'type' => 'string',
					'default' => "fade"
				),
				'enableHeight' => array(
					'type' => 'boolean',
					'default' => true
				),
				'enableWidth' => array(
					'type' => 'boolean',
					'default' => false
				),
				'titleColor' => array(
					'type' => 'string',
					'default' => '#000'
				),
				'contentColor' => array(
					'type' => 'string',
					'default' => '#000'
				),
				'layout' => array(
					'type' => 'string',
					'default' => 'layout-1'
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
			ob_start();

			?>
			<div id="<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>" class="rise-blocks-image-text-slider <?php echo esc_attr( $attrs[ 'layout' ] ); ?>" >
				<?php if( is_array( $attrs[ 'image'] ) ): ?>
					<?php foreach( $attrs[ 'image' ] as $image ): ?>
						<div class="rise-blocks-image-text-slider">
							<div class="slider-image-wrapper">
								<a class="image-slider" href="<?php echo esc_url( $image[ 'wrapper_link' ] ); ?>">
									<span class="screen-reader-text"><?php echo esc_html( $image[ 'name' ] ); ?></span>
									<img src="<?php echo esc_url( $image[ 'url' ] ); ?>" alt="<?php echo esc_attr( $image[ 'alt' ] ); ?>">
								</a>
							</div>

							<div class="slider-text-wrapper">
							    <div class="title"><?php echo esc_html( $image[ 'block_title' ] ); ?></div>
							    <div class="content"><?php echo esc_html( $image[ 'block_content' ] ); ?></div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<?php

			return ob_get_clean();
		}
	}
}

Rise_Blocks_Image_Text_Slider::get_instance()->init();
