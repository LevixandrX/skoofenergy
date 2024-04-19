<?php
/**
 * Helper class for overall plugin
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Helper' ) ):
	class Rise_Blocks_Helper{

		/**
		 * block list
		 *
		 * @var array
		 */
		protected static $block_list = array();

		/**
		 * Plugin fonts | Google Fonts
		 *
		 * @var array
		 */
		protected static $default_fonts = array(
			'Alegreya Sans'    => 'Alegreya+Sans:300,400,500,700,800,900',
			'Fjalla One'       => 'Fjalla+One',
			'Lato'             => 'Lato:300,400,700,900',
			'Montserrat'       => 'Montserrat:300,400,500,600,700,900',
			'Open Sans'        => 'Open+Sans:300,400,600,700,800',
			'Oswald'           => 'Oswald:300,400,500,600,700',
			'PT Sans Narrow'   => 'PT+Sans+Narrow',
			'Playfair Display' => 'Playfair+Display:400,700,900',
			'Raleway'          => 'Raleway:300,400,500,600,700,800,900',
			'Roboto'           => 'Roboto:300,400,500,700,900',
		);

		/* *
		 * 
		 * */
		 protected static $devices = [ 'mobile', 'tablet', 'desktop' ];

		/**
		 * Default length for excerpt
		 *
		 * @since 1.0.0
		 */
		public static $excerpt_length = 60;

		/**
		 * retrieve fonts
		 * @since 1.0.8
		 */
		public static function get_fonts(){
			return apply_filters( self::add_prefix( '%prefix-default-fonts' ), self::$default_fonts );
		}

		/**
		 * retrieve name of the block
		 *
		 * @since 1.0.0
		 */
		public static function get_block_name( $slug ){
			return self::$block_list[ $slug ][ 'name' ];
		}

		/**
		 * Get plugin prefix.
		 *
		 * @since 1.0.0
		 */
		public static function get_prefix(){
			return Rise_Blocks_Prefix;
		}

		public static function parse_args( &$a, $b ) {
			$a = (array) $a;
			$b = (array) $b;
			$result = $b;
			foreach ( $a as $k => &$v ) {
				if ( is_array( $v ) && isset( $result[ $k ] ) ) {
					$result[ $k ] = self::parse_args( $v, $result[ $k ] );
				} else {
					$result[ $k ] = $v;
				}
			}
			return $result;
		}

		/**
		 * get string with a prefix
		 *
		 * @since 1.0.0
		 * @return string
		 */
		public static function add_prefix( $cls ){
			return str_replace( '%prefix', self::get_prefix(), $cls );
		}

		public static function add_prefix_e( $cls ){
			echo esc_attr( self::add_prefix( $cls ) );
		}

		/**
		 * Returns plugin version
		 *
		 * @since 1.0.0
		 */
		public static function get_version(){
			return Rise_Blocks_Debug ? rand() : Rise_Blocks_Version;
		}

		/**
		 * Returns the information of all the blocks
		 *
		 * @since 1.0.0
		 */
		public static function get_blocks_info(){
			return self::$block_list;
		}

		public function get_block_info(){
			return array(
				'name'        => self::get_block_name( $this->slug ),
				'slug'        => $this->slug,
				'title'       => $this->title,
				'description' => $this->description,
				'demo_link'   => $this->demo_link,
				'icon'        => $this->icon
			);
		}


		/**
		 * push name of the block to an array
		 *
		 * @since 1.0.0
		 */
		public function add_block(){
			
			$block = apply_filters( 'rise-blocks/' . $this->slug . '_add_block', array(
				'name'        => 'rise-blocks/' . $this->slug,
				'title'       => $this->title,
				'description' => $this->description,
				'demo_link'   => $this->demo_link,
				'icon'        => $this->icon,
				'inserter'    => isset( $this->inserter ) ? $this->inserter : true
			));

			self::$block_list[ $this->slug ] = $block;
			return self::$block_list[ $this->slug ];
		}

		/**
		 * Some default color palettes used as an attribute for some blocks
		 *
		 * @since 1.0.0
		 */
		public static $color_palette = array(
			'white' => '#ffffff',
			'red'   => '#fc5b62',
			'black' => '#000000',
			'grey'  => '#f8f9fa ',
		);
		
		/**
		 * Include given files
		 *
		 * @since 1.0.0
		 */
		public static function includes( $name, $dir="classes", $prefix="", $path = false ){

			$prefix = empty( $prefix ) ? '' : $prefix . '-';
			if( ! $path){
				$path = Rise_Blocks_File;
			}
			$path = plugin_dir_path( $path ) . $dir . '/' . $prefix;
			if( is_array( $name ) ){
				foreach( $name as $file ){
					require_once $path . $file . '.php';
				}
			}else{
				require_once $path . $name . '.php';
			}
		}

		/**
		 * Retrives plugin directory uri
		 *
		 * @since 1.0.0
		 */
		public static function get_plugin_directory_uri(){
			return esc_url( plugins_url( '/', Rise_Blocks_File ) );
		}

		public static function render_svg( $svg ){

			$kses_defaults = wp_kses_allowed_html( 'post' );
			$svg_args = array(
			    'svg' => array(
			        'class'           => true,
			        'aria-hidden'     => true,
			        'aria-labelledby' => true,
			        'role'            => true,
			        'xmlns'           => true,
			        'width'           => true,
			        'height'          => true,
			        'style'           => true,
			        'fill'            => true,
			        'viewbox'         => true, // <= Must be lower case!
			        'enable-background' => true,
			    ),
			    'g'     => array( 'fill' => true ),
			    'title' => array( 'title' => true ),
			    'path'  => array( 
			        'd'    => true, 
			        'fill' => true  
			    ),
			    'image' => array(
			    	'x' => true,
			    	'y' => true,
			    	'width' => true,
			    	'height' => true,
			    	'xlink:href' => true
			    )
			);
			$allowed_tags = array_merge( $kses_defaults, $svg_args );

			echo wp_kses( $svg, $allowed_tags );
		}

		/**
		 * Enqueue scripts or styles
		 *
		 * @since 1.0.0
		 */
		public static function enqueue( $scripts, $uri=false ){

		    # Do not enqueue anything if no array is supplied.
		    if( ! is_array( $scripts ) ) return;

		    if(! $uri){
		    	$uri = self::get_plugin_directory_uri();
		    }
		    
		    foreach ( $scripts as $script ) {

		        # Do not try to enqueue anything if handler is not supplied.
		        if( ! isset( $script[ 'handler' ] ) )
		            continue;

		        $version = null;
		        if( isset( $script[ 'version' ] ) ){
		            $version = $script[ 'version' ];
		        }

		        $minified = isset( $script[ 'minified' ] ) ? $script[ 'minified' ] : true;
		        # Enqueue each vendor's style
		        if( isset( $script[ 'style' ] ) ){

					$path = $uri .  $script[ 'style' ];
					if( isset( $script[ 'absolute' ] ) ){
		                $path = $script[ 'style' ];
		            }
		           
		            $dependency = array();
		            if( isset( $script[ 'dependency' ] ) ){
		                $dependency = $script[ 'dependency' ];
		            }

	            	if( Rise_Blocks_Debug === false && $minified ){
	            		$path = str_replace( '.css', '.min.css', $path );
	            	}
	           
		            wp_enqueue_style( $script[ 'handler' ], $path, $dependency, $version );
		        }

		        # Enqueue each vendor's script
		        if( isset( $script[ 'script' ] ) ){

		        	if( $script[ 'script' ] === true || $script[ 'script' ] === 1 ){
		        		wp_enqueue_script( $script[ 'handler' ] );
		        	}else{

			            $prefix = '';
			            if( isset( $script[ 'prefix' ] ) ){
			                $prefix = $script[ 'prefix' ];
			            }

			        	$path = '';
			        	if( isset( $script[ 'script' ] ) ){
							$path = $uri .  $script[ 'script' ];
			        	}

			            if( isset( $script[ 'absolute' ] ) ){
			                $path = $script[ 'script' ];
			            }

			            $dependency = array( 'jquery' );
			            if( isset( $script[ 'dependency' ] ) ){
			                $dependency = $script[ 'dependency' ];
			            }

			            $in_footer = true;

			            if( isset( $script[ 'in_footer' ] ) ){
			            	$in_footer = $script[ 'in_footer' ];
			            }

			            if( Rise_Blocks_Debug === false && $minified ){
			            	$path = str_replace( '.js', '.min.js', $path );
			            }
			            wp_enqueue_script( $prefix . $script[ 'handler' ], $path, $dependency, $version, $in_footer );
		        	}
		        }
		    }
		}

		/**
		 * Get date permalink
		 * 
		 * @return string
		 * @since 1.0.0
		 */
		public static function get_date_link(){
			return get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') );
		}

		/**
		 * Prints current date of the posts
		 * 
		 * @return void
		 * @since 1.0.0
		 */
		public static function the_date(){
			?>
			<a href="<?php echo esc_url( self::get_date_link() ); ?>" target="_blank">
				<?php echo get_the_date(); ?>
			</a><?php
		}

		/**
		 * return total comment in a posts
		 * 
		 * @return int
		 * @since 1.0.0
		 */
		public static function get_total_comment( $object ) {
		    # Get the comments link.
		    $id = is_array( $object )? $object[ 'id' ] : $object;
		    $comments_count = wp_count_comments( $object['id'] );
		    return $comments_count->total_comments;
		}

		/**
		 * get categories associated with the post
		 * 
		 * @return mixed
		 * @since 1.0.0
		 */
		public static function get_categories( $object ){
			$id = is_array( $object )? $object[ 'id' ] : $object;
			return get_the_category( $id );
		}

		/**
		 * Get the site-wide option if we're in the network admin.
		 *
		 * @param string $key
		 * @param boolean $default
		 * @return string
		 */
		public static function get_option( $key, $default = false ) {
			return is_multisite() ?  get_site_option( $key, $default ) : get_option( $key, $default );
		}

		/**
		 * Update the site-wide option since we're in the network admin.
		 *
		 * @param string $key
		 * @param string $value
		 * @return void
		 */
		public static function update_option( $key, $value ) {
			if ( is_multisite() ) {
				update_site_option( $key, $value );
			} else {
				update_option( $key, $value );
			}
		}

		/**
		 * returns permalink for day
		 *
		 * @return string
		 */
		public static function get_day_link(){
			return get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') );
		}

		/**
		 * return read more text
		 *
		 * @param string $more
		 * @return string
		 */
		public static function excerpt_more( $more ) {
			$more = '..';
		    return $more;
		}

		/**
		 * Returns length of the excerpt
		 *
		 * @param int $length
		 * @return int
		 */
		public static function excerpt_length( $length ){
			return self::$excerpt_length;
		}

		/**
		 * Modify excerpt format of a post
		 *
		 * @param int $length
		 * @param boolean $echo
		 * @param object $post
		 * @return void
		 */
		public static function excerpt( $length, $echo= true, $post = null ){

			if( $length ){ self::$excerpt_length = $length; }

			add_filter( 'excerpt_more', array( __CLASS__, 'excerpt_more' ), 999 );
			add_filter( 'excerpt_length', array( __CLASS__, 'excerpt_length' ) );

			$excerpt = get_the_excerpt( $post );
			if( $echo ){ echo wp_kses_post( $excerpt ); }

			remove_filter( 'excerpt_length', array( __CLASS__, 'excerpt_length' ) );
			remove_filter( 'excerpt_more', array( __CLASS__, 'excerpt_more' ), 999 );

			if( !$echo ){ return wp_kses_post( $excerpt ); }
		}

		/**
		 * Returns the excerpt of a post
		 *
		 * @param object $object
		 * @return string
		 */
		public static function get_excerpt( $object ){
			$id = is_array( $object ) ? $object[ 'id' ] : $object;
			return self::excerpt( false, false, $id );
		}

		/**
		* Generate style of gutter and grid width
		* @access private
		* @since 1.0.0
		* @return null
		*/
		static function get_gutter_properties( $selector, $value, $init_gap=0 ){
			$default = array(
				'desktop' => array( 'items_per_row' => 3, 'gutter' => 30 ),
				'tablet' => array( 'items_per_row' => 2, 'gutter' => 30 ),
				'mobile' => array( 'items_per_row' => 1, 'gutter' => 30 )
			);

			$param = self::parse_args( $value, $default);

			$return_arr = array();

			foreach( $param as $key => $value){

				$items_per_row = $value['items_per_row'];
				$gutter_size = $value['gutter'];
				
				$width = 'calc('. (100 / $items_per_row) .'% - '. $gutter_size * ($items_per_row - 1) / $items_per_row.'px)';
				$margin = ( ($init_gap + $gutter_size) / 2).'px 0';

				/* .rise-blocks-block-lists > div' */
				$css = array(
					array(
						'selector' => $selector,
						'props' => array(
							'width' => array( 'value' => $width ),
							'margin' => array('value' => $margin)
						)
					)
				);
				$return_arr[$key] = $css;
			}

			return $return_arr;
		}
	}
endif;