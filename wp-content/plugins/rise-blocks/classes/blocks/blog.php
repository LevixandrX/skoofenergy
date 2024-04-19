<?php
/**
 * Render Blog block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Blog' ) ){
	
	class Rise_Blocks_Blog extends Rise_Blocks_Base{

		/**
		* Name of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'blog';

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
        protected $demo_link = 'rise-blocks/latest-blog';

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
			$this->title       = esc_html__( 'Blog', 'rise-blocks' );
			$this->description = esc_html__( 'This block will fetch five blog articles either all posts or by category and show it in a grid format.', 'rise-blocks' );
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

				foreach( [ 'mobile', 'tablet', 'desktop' ] as $device ){
					$css = array(
						array(
							'selector' => self::add_prefix( '.%prefix-blog-post-title' ),
							'props'    => $title_typo[ $device ]
						),
						array(
							'selector' => '.meta-content',
							'props'    => $meta_typo[ $device ]
						),
						array(
							'selector' => self::add_prefix( '.%prefix-blog-post-content p' ),
							'props'    => $content_typo[ $device ]
						),
					);

					self::add_styles( array(
						'attrs' => $attrs,
						'css'   => $css,
					), $device );
				}

				$dynamic_css = array(
					array(
						'selector' => self::add_prefix( '.%prefix-blog-meta-wrapper a' ),
						'props' => array(
							'color' => 'metaColor'
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-blog-post-title a' ),
						'props'    =>  array(
							'color' => 'titleColor'
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-blog-post-title:hover a' ),
						'props'    => array(
							'color' => 'titleHoverColor'
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-blog-post-content p' ),
						'props'    => array(
							'color' => 'contentColor'
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
					'default' => 5,
				),
				'perRow' =>  array(
					'type' => 'number',
					'default' => 2
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
								'desktop' => 1.2,
								'tablet'  => 1.2,
								'mobile'  => 1.2
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
								'desktop' => 1.8,
								'tablet'  => 1.8,
								'mobile'  => 1.8
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
								'desktop' => 1.2,
								'tablet'  => 1.2,
								'mobile'  => 1.2
							)
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
				'enableFullContent' => array(
					'type' => 'boolean', 
					'default' => false
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
				'enableImage' => array(
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
					'default' => 20
				),

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

		public function get_query( $attrs ){

			$args = array(
				'post_type'   => 'post',
				'post_status' => 'publish',
				'ignore_sticky_posts' => true,
				'posts_per_page' => $attrs[ 'postsToShow' ],
				'order'   => $attrs[ 'order' ],
				'orderby' => $attrs[ 'orderBy' ]
			);

			if( isset( $attrs[ 'categories' ] ) ){
				$args[ 'cat' ] = $attrs[ 'categories' ];
			}
			
			$query = new WP_Query( apply_filters( self::add_prefix('%prefix_blog_query'), $args ) );

			return $query;
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

			$query = $this->get_query( $attrs );
			
			if( $query->have_posts() ):
				ob_start();

				if( isset( $attrs[ 'categories' ] ) ){
					$_cat = get_category( absint( $attrs[ 'categories' ] ) );
					$cat = self::make_category_arr( $_cat );
				}
				
				$section_cls = self::add_prefix( '%prefix-blog-wrapper %prefix-item-' . esc_attr( $attrs[ 'perRow' ] ) . '-per-row %prefix-align-' . esc_attr( $attrs[ 'alignment' ] ) );
				
				?>
				<div id="<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>">
					<section class="<?php echo esc_attr( $section_cls ); ?>">
					    <?php while( $query->have_posts() ): 
					    	$query->the_post(); 

					    	$id        = get_the_ID();
					    	$author_id = get_the_author_meta( 'ID' );

					    	$avatar      = get_avatar_url( $author_id );
					    	$author_link = get_author_posts_url( $author_id );

					    	if( !isset( $attrs[ 'categories' ] ) ){
					    		$_cat = get_the_category();
					    		if( isset( $_cat[0] ) ){
					    			$cat = self::make_category_arr( $_cat[ 0 ] );
					    		}else{
					    			$cat = array(
					    				'link' => '',
					    				'name' => ''
					    			);
					    		}
					    	}
					 
					    ?>
				            <div class="<?php self::add_prefix_e( '%prefix-blog-card-wrapper' ); ?>">
				                <div class="<?php self::add_prefix_e( '%prefix-blog-card' ); ?>">
				                    <?php if( $attrs['enableImage'] && has_post_thumbnail() ): ?>
				                    	<?php
				                    		$src = get_the_post_thumbnail_url( $id, $attrs[ 'imageSize' ] );
				                    		$attachment_id = get_post_thumbnail_id( $id );
				                    		$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
				                    	?>
				                    	<a href="<?php the_permalink(); ?>" 
				                    		class="<?php self::add_prefix_e( '%prefix-blog-image' ); ?>">
				                    		<span class="screen-reader-text"><?php echo esc_html( $alt ); ?></span>
				                    	    <img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
				                    	</a>
				                    <?php endif; ?>
				                    <div class="<?php self::add_prefix_e( '%prefix-blog-body' ); ?>">

				                    <?php if( $attrs[ 'enableAuthor' ] || $attrs[ 'enableDate' ] || $attrs[ 'enableCategory' ] ): ?>
				                        <div class="<?php self::add_prefix_e( '%prefix-blog-meta-wrapper' ); ?>">
				                        	<?php if( $attrs[ 'enableAuthor' ] ): ?>
				                                <div class="<?php self::add_prefix_e( '%prefix-blog-author meta-content' ); ?>">
				                                    <a href="<?php echo esc_url( $author_link ); ?>">
				                                        <img src="<?php echo esc_attr( $avatar ); ?>" 
				                                            class="<?php self::add_prefix_e( '%prefix-blog-author-img' ); ?>"
				                                            alt="avatar"
				                                        />
				                                        <span><?php echo ucfirst( get_the_author() ); ?></span>
				                                    </a>
				                                </div>
				                        	<?php endif; ?>

				                        	<?php if( $attrs[ 'enableDate' ] ): ?>
				                                <div class="<?php self::add_prefix_e( '%prefix-blog-post-date meta-content' ); ?>" >
				                                    <a href="<?php echo esc_url( self::get_day_link() ) ?>">
				                                        <span>
				                                        	<?php echo get_the_date(); ?>
				                                    	</span>
				                                    </a>
				                                </div>
				                        	<?php endif; ?>

				                        	<?php if( isset( $cat ) && $attrs[ 'enableCategory' ] ): ?>
				                                <div class="<?php self::add_prefix_e( '%prefix-blog-post-cat meta-content' ); ?>">
				                                    <a href="<?php echo esc_url( $cat[ 'link' ] ); ?>">
				                                        <span><?php echo esc_html( $cat[ 'name' ] ); ?></span>
				                                    </a>
				                                </div>
				                            <?php endif; ?>
				                        </div>
				                    <?php endif; ?>

				                    <?php if( $attrs[ 'enableTitle' ] || $attrs[ 'enableContent' ] || $attrs[ 'enableFullContent' ] ): ?>
				                        <div class="<?php self::add_prefix_e( '%prefix-blog-post-content' ); ?>">
				                        	<?php if( $attrs[ 'enableTitle' ] ): ?>
					                            <h2 class="<?php self::add_prefix_e( '%prefix-blog-post-title' ); ?>">
					                                <a href="<?php the_permalink(); ?>">
					                                    <?php the_title(); ?>
					                                </a>
					                            </h2>
				                        	<?php endif; ?>

            	                           <?php 
					                            if( $attrs[ 'enableFullContent' ] ){
					                            	the_content();
					                            }
				                            ?>

				                            <?php 
					                            if( $attrs[ 'enableContent' ] ){
					                            	echo '<p>';
					                           		self::excerpt( $attrs[ 'excerptLength' ] );
					                           		echo '</p>';
					                            }
				                            ?>
				                        </div>
				                    <?php endif; ?>
				                    </div>
				                </div>
				            </div>                   
					    <?php endwhile; ?>   	
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

Rise_Blocks_Blog::get_instance()->init();