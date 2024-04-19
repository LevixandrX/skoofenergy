<?php
/**
 * Render Blog block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_News_1' ) ){
	
	class Rise_Blocks_News_1 extends Rise_Blocks_Base{

		/**
		* Name of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'news-1';

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
		protected $icon = '<svg id="Capa_1" fill="#436DD3" enable-background="new 0 0 512 512" height="128" viewBox="0 0 512 512" width="128" xmlns="http://www.w3.org/2000/svg"><g><path d="m444.5 218.5c4.143 0 7.5-3.358 7.5-7.5v-90c0-4.142-3.357-7.5-7.5-7.5h-75c-4.143 0-7.5 3.358-7.5 7.5v90c0 4.142 3.357 7.5 7.5 7.5zm-67.5-90h60v75h-60z"/><path d="m504.5 53.5h-497c-4.142 0-7.5 3.358-7.5 7.5v390c0 4.142 3.358 7.5 7.5 7.5h497c4.143 0 7.5-3.358 7.5-7.5v-390c0-4.142-3.357-7.5-7.5-7.5zm-7.5 390h-482v-375h482z"/><path d="m37.5 428.5h437c4.143 0 7.5-3.358 7.5-7.5v-330c0-4.142-3.357-7.5-7.5-7.5h-437c-4.142 0-7.5 3.358-7.5 7.5v150c0 4.142 3.358 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-142.5h422v315h-422v-142.5c0-4.142-3.358-7.5-7.5-7.5s-7.5 3.358-7.5 7.5v150c0 4.142 3.358 7.5 7.5 7.5z"/><path d="m263.5 391v-270c0-4.142-3.357-7.5-7.5-7.5-4.142 0-7.5 3.358-7.5 7.5v270c0 4.142 3.358 7.5 7.5 7.5 4.143 0 7.5-3.358 7.5-7.5z"/><path d="m278.5 271c0 4.142 3.357 7.5 7.5 7.5h158.5c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-158.5c-4.143 0-7.5 3.358-7.5 7.5z"/><path d="m286 308.5h158.5c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-158.5c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5z"/><path d="m286 338.5h158.5c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-158.5c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5z"/><path d="m226 398.5c4.142 0 7.5-3.358 7.5-7.5v-270c0-4.142-3.358-7.5-7.5-7.5h-158.5c-4.142 0-7.5 3.358-7.5 7.5v270c0 4.142 3.358 7.5 7.5 7.5zm-151-270h143.5v255h-143.5z"/></g></svg>';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.0
        * @var string
        */
        protected $demo_link = 'rise-blocks/news-1';

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
			$this->title       = esc_html__( 'News Block #1', 'rise-blocks' );
			$this->description = esc_html__( 'This block enables blog articles either all posts or by category to create a grid layout for Magazine or Blogging websites in a few seconds.', 'rise-blocks' );
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
				
				# Typography for title, content on mobile
				$title_typo = self::get_initial_responsive_props();
				if( isset( $attrs[ 'titleTypo' ] ) ){
					$title_typo = self::get_typography_props(  $attrs[ 'titleTypo' ] );
				}

				$content_typo = self::get_initial_responsive_props();
				if( isset( $attrs[ 'contentTypo' ] ) ){	
					$content_typo = self::get_typography_props(  $attrs[ 'contentTypo' ] );
				}

				$meta_typo = self::get_initial_responsive_props();
				if( isset( $attrs[ 'metaTypo' ] ) ){	
					$meta_typo = self::get_typography_props(  $attrs[ 'metaTypo' ] );
				}

				$padding = self::get_dimension_props( 'padding', $attrs[ 'padding' ] );
				$height = self::get_responsive_props( $attrs[ 'height' ], 'height' );
				$smallHeight = self::get_responsive_props( $attrs[ 'smallHeight' ], 'height' );

				foreach( [ 'mobile', 'tablet', 'desktop' ] as $device ){
					$css = array(
						array(
							'selector' => self::add_prefix( '.%prefix-news-1-post-title a' ),
							'props'    => $title_typo[ $device ]
						),
						array(
							'selector' => '.meta-content',
							'props'    => $meta_typo[ $device ]
						),
						array(
							'selector' => self::add_prefix( '.%prefix-news-1-post-content p' ),
							'props'    => $content_typo[ $device ]
						),
						array(
							'selector' => self::add_prefix( '.%prefix-news-1-card-wrapper' ),
							'props' => $padding[ $device ],
						),
						array(
							'selector' => self::add_prefix( '.%prefix-news-1-card-wrapper.col-big' ),
							'props' => $height[ $device ]
						),
						array(
							'selector' => self::add_prefix( '.%prefix-news-1-card-wrapper.col-small' ),
							'props' => $smallHeight[ $device ]
						)
					);

					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device );
				}

				$dynamic_css = array(
					array(
						'selector' => self::add_prefix( '.%prefix-news-1-meta-wrapper a' ),
						'props' => array(
							'color' => 'metaColor'
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-news-1-post-title a' ),
						'props'    =>  array(
							'color' => 'titleColor'
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-news-1-post-title:hover a' ),
						'props'    => array(
							'color' => 'titleHoverColor'
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-news-1-post-content p' ),
						'props'    => array(
							'color' => 'contentColor'
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-news-1-overlay' ),
						'props'    => array(
							'background-color' => 'overlayColor'
						)
					)
				);

				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => $dynamic_css,
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
				'alignment' => array( 
					'type' => 'string',
					'default' => 'left'
				),
				# Post Setting
				'postsToShow'     => array(
					'type'    => 'number',
					'default' => 3,
				),
				'order'           => array(
					'type'    => 'string',
					'default' => 'desc',
				),
				'orderBy'         => array(
					'type'    => 'string',
					'default' => 'date',
				),
				'categories' => array(
					'type' => 'string',
				),

				'titleTypo' => array(
					'type' => 'object',
					'default' => array(
						'fontFamily' => 'Lato',
						'fontSize'   => array(
							'units' => array( 'px', 'em', 'rem' ),
							'activeUnit' => 'px',
							'values' => array(
								'desktop' => 22,
								'tablet'  => 22,
								'mobile'  => 22
							)
						),
						'fontWeight' => 600,
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
						'fontFamily' => 'Lato',
						'fontSize'   => array(
							'units' => array( 'px', 'em', 'rem' ),
							'activeUnit' => 'px',
							'values' => array(
								'desktop' => 16,
								'tablet'  => 16,
								'mobile'  => 16
							)
						),
						'fontWeight' => 400,
						'lineHeight' => array(
							'activeUnit' => '',
							'units'      => array( '' ),
							'values'     => array(
								'desktop' => '1.8',
								'tablet'  => '1.8',
								'mobile'  => '1.8'
							)
						)
					)
				),
				'metaTypo' => array(
					'type' => 'object',
					'default' => array(
						'fontFamily' => 'Lato',
						'fontSize'   => array(
							'units' => array( 'px', 'em', 'rem' ),
							'activeUnit' => 'px',
							'values' => array(
								'desktop' => 12,
								'tablet'  => 12,
								'mobile'  => 12
							)
						),
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

				'height' => array(
					'type' => 'object',
					'default' => array(
						'activeUnit' => 'px',
						'units' => array( 'px' ),
						'range' => array(
							'min' => 1,
							'max' => 1500
						),
						'values' => array(
							'desktop' => 500,
							'tablet' => 500,
							'mobile' => 500
						)
					)
				),
				'smallHeight' => array(
					'type' => 'object',
					'default' => array(
						'activeUnit' => 'px',
						'units' => array( 'px' ),
						'range' => array(
							'min' => 1,
							'max' => 1500
						),
						'values' => array(
							'desktop' => 240,
							'tablet' => 240,
							'mobile' => 240
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
						'units' => array( 'px', 'rem' ),
						'values' => array(
							'desktop' => array( 20, 20, 20, 20 ),
							'tablet' => array( 20, 20, 20, 20 ),
							'mobile' => array( 20, 20, 20, 20 ),
						)  
					)
				),

				'enableTitle' => array(
					'type' => 'boolean',
					'default' => true
				),
				'enableContent' => array(
					'type' => 'boolean', 
					'default' => true
				),
				'enableCategory' => array(
					'type' => 'boolean',
					'default' => true
				),
				'enableAuthor' => array(
					'type' => 'boolean',
					'default' => true
				),
				'enableDate' => array(
					'type' => 'boolean',
					'default' => true
				),
				'imageSize' => array(
					'type' => 'string',
					'default' => 'full'
				),

				'titleColor' => array(
					'type' => 'string',
				),
				'titleHoverColor' => array(
					'type' => 'string',
				),
				'contentColor' => array(
					'type' => 'string',
				),
				'metaColor' => array(
					'type' => 'string',
				),
				'excerptLength' => array(
					'type' => 'number',
					'default' => 7
				),
				'overlayColor' => array(
					'type'    => 'string',
					'default' => 'rgba(0, 0, 0, 0.3)'
				)
			);
		}

	   /**
		* get array of category
		*
		* @access public
		* @since 1.0.0
		* @return string
		*/
		public static function make_category_arr( $_cat ){
			$cat = false;
			if( $_cat ){
				$cat = array(
					'name' => $_cat->name,
					'link' => get_category_link( $_cat->term_id )
				);
			}

			return $cat;
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
			$args = array(
				'post_type'   => 'post',
				'post_status' => 'publish',
				'ignore_sticky_posts' => true,
				'posts_per_page' => $attrs[ 'postsToShow' ],
				'order' => $attrs[ 'order' ],
				'orderby' => $attrs[ 'orderBy' ]
			);

			if( isset( $attrs[ 'categories' ] ) ){
				$args[ 'cat' ] = $attrs[ 'categories' ];
			}
		
			$query = new WP_Query( apply_filters( self::add_prefix('%prefix_news_1_query'), $args ) );
			
			if( $query->have_posts() ):
				ob_start();

				if( isset( $attrs[ 'categories' ] ) ){
					$_cat = get_category( absint( $attrs[ 'categories' ] ) );
					$cat = self::make_category_arr( $_cat );
				}
				

				$section_cls = self::add_prefix( '%prefix-news-1-wrapper %prefix-align-' . esc_attr( $attrs[ 'alignment' ] ) );
				
				?>
				<div id="<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>">
					<section class="<?php echo esc_attr( $section_cls ); ?>">
					    <?php $count = 0; while( $query->have_posts() ): 
					    	$query->the_post(); 

					    	$id        = get_the_ID();
					    	$author_id = get_the_author_meta( 'ID' );

					    	$author_link = get_author_posts_url( $author_id );

					    	if( !isset( $attrs[ 'categories' ] ) ){
					    		$_cat = get_the_category();
					    		$cat = self::make_category_arr( $_cat[ 0 ] );
					    	}

					    	$src = '';
				            if( has_post_thumbnail( ) ){
				            	$src = get_the_post_thumbnail_url( $id, $attrs[ 'imageSize' ] );
				            	$attachment_id = get_post_thumbnail_id( $id );
				            	$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
				            }

							$col = ( $count % 3 == 0 ) ? 'col-big' : 'col-small';

					    ?>
				            <div class="<?php self::add_prefix_e( '%prefix-news-1-card-wrapper' ); echo ' '. esc_attr( $col ); ?>" style="background: url( <?php echo esc_url( $src ); ?>)">
				            	<div class="<?php self::add_prefix_e( '%prefix-news-1-overlay' ); ?>"></div>
				                <div class="<?php self::add_prefix_e( '%prefix-news-1-card' ); ?>">
				                    <div class="<?php self::add_prefix_e( '%prefix-news-1-body' ); ?>">

			                    		<?php if( $attrs[ 'enableCategory' ] ): ?>
			                    	        <div class="<?php self::add_prefix_e( '%prefix-news-1-post-cat meta-content' ); ?>">
			                    	            <a href="<?php echo esc_url( $cat[ 'link' ] ); ?>">
			                    	                <span><?php echo esc_html( $cat[ 'name' ] ); ?></span>
			                    	            </a>
			                    	        </div>
			                    	    <?php endif; ?>

    	                            	<?php if( $attrs[ 'enableTitle' ] ): ?>
    	    	                            <h2 class="<?php self::add_prefix_e( '%prefix-news-1-post-title' ); ?>">
    	    	                                <a href="<?php the_permalink(); ?>">
    	    	                                    <?php the_title(); ?>
    	    	                                </a>
    	    	                            </h2>
    	                            	<?php endif; ?>

					                    <?php if( $attrs[ 'enableAuthor' ] || $attrs[ 'enableDate' ] ): ?>
					                        <div class="<?php self::add_prefix_e( '%prefix-news-1-meta-wrapper' ); ?>">
					                        	<?php if( $attrs[ 'enableAuthor' ] ): ?>
					                                <div class="<?php self::add_prefix_e( '%prefix-news-1-author meta-content' ); ?>">
					                                    <a href="<?php echo esc_url( $author_link ); ?>" title="<?php echo ucfirst( get_the_author() ); ?>">
					                                        <i class="fa fa-user"></i>
					                                    </a>
					                                </div>
					                        	<?php endif; ?>

					                        	<?php if( $attrs[ 'enableDate' ] ): ?>
					                                <div class="<?php self::add_prefix_e( '%prefix-news-1-post-date meta-content' ); ?>" >
					                                    <a href="<?php echo esc_url( self::get_day_link() ) ?>">
					                                        <span>
					                                        	<?php echo get_the_date(); ?>
					                                    	</span>
					                                    </a>
					                                </div>
					                        	<?php endif; ?>
					                        	
					                        </div>
					                    <?php endif; ?>

					                    <?php if( $attrs[ 'enableContent' ] ): ?>
					                        <div class="<?php self::add_prefix_e( '%prefix-news-1-post-content' ); ?>">
					                        	<p><?php self::excerpt( $attrs[ 'excerptLength' ] ); ?></p>
					                        </div>
					                    <?php endif; ?>
				                    </div>
				                </div>
				            </div>                   
					    <?php $count++; endwhile; ?>   	
					</section>
				</div>
				<?php

				wp_reset_postdata();
				$block_content = ob_get_clean();
			endif; 

			return $block_content;
		}
	}
}

Rise_Blocks_News_1::get_instance()->init();
