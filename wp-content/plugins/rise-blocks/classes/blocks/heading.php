<?php
/**
 * Render Advanced Heading block
 *
 * @since 1.0.0
 * @package Rise Block
 */

if( !class_exists( 'Rise_Blocks_Heading' ) ){
	
	class Rise_Blocks_Heading extends Rise_Blocks_Base{

		/**
		* Slug of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $slug = 'heading';

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
	        <image  x="0px" y="0px" width="60px" height="60px"  xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFQAAABUCAMAAAArteDzAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAANlBMVEUAAAA3Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc83Yc/////8VXeKAAAAEHRSTlMA30Bgr88gn78QgO9wMFCP82MiegAAAAFiS0dEEeK1PboAAAAHdElNRQfjCRcLNwLuhuAiAAAB/UlEQVRYw+2YUZODIAyEVWpVapX//2s7N3NuECEkkkf3qXPCGsN+Xsauk6gP/xpEy0Vyh2d42ZmOMA1vK8+BPMNkZTpHpmGx8XzHnsHbmE4n049JqedCQ3AWpj4x7Q08l0+wL3VFhcePud0UXl87Vh3Vh5/NAIDQLepuI6sg9O/Md6NSQejaRYltAyCxAVtNrMJlPzfj0+C5pK9RdKMBAJ+eDFJ1n1XKEOIOALa7plHwD63XPynVXzuYKf5moXEDp7TNSuGo41TSK/sWqxTKEz+vplILuwv3kqn4nGOuK0LhRNJJpwEAIvSSnUzShAKhY/mStlQKuWOuKQFgG4d2K1lF33JHTMH4ajw3bMuGEaypAKjsooFVwWp1E7qzy01peJzzgqmc1XR45CRmdVKYSgG4Do+chKx6jae0VFWhQladzlPGaq80lQCwaT0lrILQ2mM5ealEaHWwwYFWAUDw61FB9GqsEqFr1XSRrt2ld1c8FREqead9USrLKhEqevsiKSO3CsGX/Z+gTDOsOsmibBFz25pCFcV2DbLGR6KDLfYLfZfPM3utVEpIPfiHCJYCq8iyZpytbKKbauaOyjlU25MXexB0kLqPhI4rlQhVTp1cuHFt1Hly1Ti+4YyYvu3H7KX/7Ooxtxl9sXz06KLBXu8u2Ms/po+ptam31/ADgmyF4t4vg04AAAAASUVORK5CYII=" />
	    </svg>';

        /**
        * link to the demo of this block.
        *
        * @access protected
        * @since 1.0.0
        * @var string
        */
        protected $demo_link = 'rise-blocks/advanced-heading';
        
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
			$this->title       = esc_html__( 'Advanced Heading', 'rise-blocks' );
			$this->description = esc_html__( 'This block enables attractive heading for the page or section with the label feature to show extra information.', 'rise-blocks' );
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
		* Generate & Print Frontend Styles
		* Called in wp_head hook
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public function prepare_scripts_styles(){

			$this->get_blocks();

			if( count( $this->blocks ) > 0 ){
				# Description uses Raleway as a default font family
				self::add_font( 'Raleway' );
			}
			
			foreach( $this->blocks as $block ){

				$attrs = self::get_attrs_with_default( $block[ 'attrs' ] );

				$title_typography = self::get_initial_responsive_props();
				if( isset( $attrs[ 'titleTypography' ] ) ){
					$title_typography = self::get_typography_props( $attrs[ 'titleTypography' ] );
				}

				$label_typography = self::get_initial_responsive_props();
				if( isset( $attrs[ 'labelTypography' ] ) ){
					$label_typography = self::get_typography_props( $attrs[ 'labelTypography' ] );
				}

				$section_padding = self::get_initial_responsive_props();
				if( isset( $attrs[ 'sectionPadding' ] ) ){
					$section_padding  = self::get_dimension_props( 'padding',
						$attrs[ 'sectionPadding' ]
					);
				}

				$title_margin = self::get_initial_responsive_props();
				if( isset( $attrs[ 'titleMargin' ] ) ){
					$title_margin = self::get_dimension_props( 'margin',
						$attrs[ 'titleMargin' ]
					);
				}

				$description_typography = self::get_initial_responsive_props();

				if( isset( $attrs[ 'descriptionTypography' ] ) ){
					$description_typography = self::get_typography_props( $attrs[ 'descriptionTypography' ] );
				}

				$description_padding = self::get_initial_responsive_props();
				if( isset( $attrs[ 'descriptionPadding' ] ) ){
					$description_padding = self::get_dimension_props( 'padding',
						$attrs[ 'descriptionPadding' ]
					);
				}

				# ADVANCE HEADING mobile style
				$mobile_css = array(
					array(
						'selector' => self::add_prefix( '.%prefix-heading-section' ),
						'props' => $section_padding['mobile']
					),
					array(
						'selector' => self::add_prefix( '.%prefix-title' ),
						'props' => array_merge(
							$title_typography['mobile'],
							$title_margin['mobile']
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-sub-title' ),
						'props' => array_merge(
							$label_typography['mobile']
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-sub-description' ),
						'props' => array_merge(
							$description_typography['mobile'],
							$description_padding['mobile']
						)
					)
				);
				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => $mobile_css,
				), 'mobile');


				# ADVANCE HEADING tablet style
				$tablet_css = array(
					array(
						'selector' => self::add_prefix( '.%prefix-heading-section' ),
						'props' => $section_padding[ 'tablet' ]
					),
					array(
						'selector' => self::add_prefix( '.%prefix-title' ),
						'props' => array_merge(
							$title_typography[ 'tablet' ],
							$title_margin[ 'tablet' ]
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-sub-title' ),
						'props' => array_merge(
							$label_typography['tablet']
						)
					),
					array(
						'selector' => self::add_prefix( '.%prefix-sub-description' ),
						'props' => array_merge(
							$description_typography['tablet'],
							$description_padding['tablet']
						)
					)
				);
				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => $tablet_css,
				), 'tablet');

				# ADVANCE HEADING Desktop style
				$label = array(
					'color' => 'labelColor',
					'border-color' => 'labelColor',
					'border-style' => 'labelBorderStyle'
				);

				$label = array_merge( $label, $label_typography[ 'desktop' ] );

				$title = array_merge(
					$title_margin['desktop'],
					$title_typography['desktop'],
					array( 'color' => 'titleColor' )
				);				

				$description = array_merge(
					$description_padding['desktop'],
					$description_typography['desktop'],
					array( 'color' => 'descriptionColor' )
				);
				
				$line = array( 'background-color' => 'lineColor' );

				$desktop_css = array(
					array(
						'selector' => self::add_prefix( '.%prefix-heading-section' ),
						'props'    => $section_padding['desktop']
					),
					array(
						'selector' => self::add_prefix( '.%prefix-sub-title' ),
						'props'    => $label
					),
					array(
						'selector' => self::add_prefix( '.%prefix-title' ),
						'props'    => $title
					),
					array(
						'selector' => self::add_prefix( '.%prefix-sub-description' ),
						'props'    => $description
					),
					array(
						'selector' => self::add_prefix( '.%prefix-line' ),
						'props'    =>  $line
					)
				);
				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => $desktop_css,
				));
			}
		}
	}
}

Rise_Blocks_Heading::get_instance()->init();
