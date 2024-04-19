<?php
/**
 * Render Slider block
 *
 * @since 1.0.0
 * @package Rise Block
 */
if (!class_exists('Rise_Blocks_Slider')) {

    class Rise_Blocks_Slider extends Rise_Blocks_Base
    {

        /**
         * Name of the block.
         *
         * @access protected
         * @since 1.0.0
         * @var string
         */
        protected $slug = 'page-slider';

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
        protected $demo_link = 'rise-blocks/page-slider';

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
        public function __construct()
        {
            $this->title = esc_html__('Slider', 'rise-blocks');
            $this->description = esc_html__('This block enables you to fetch other pages’ heading and excerpts; and display it in a carousel layout with a link.', 'rise-blocks');
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
        public static function get_instance()
        {
            if (!self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Enqueue Common Scripts and Styles
         * Called in enqueue_block_assets hook
         * Fires in frontend and backend
         * @access public
         * @since 1.0.0
         * @return null
         */
        public function block_assets()
        {

            $scripts = array(
                array(
                    'handler' => 'slick',
                    'style' => 'vendors/slick/slick.css',
                    'version' => '1.8.1',
                ),
            );
            $this->enqueue_block_assets($scripts);
        }

        /**
         * Enqueue Frontend Scripts and Styles
         * Called in wp_enqueue_scripts hook
         * Fires in frontend
         * @access public
         * @since 1.0.0
         * @return null
         */
        public function enqueue_scripts_styles()
        {
            if (count($this->blocks) > 0) {
                $scripts = array(
                    array(
                        'handler' => 'slick',
                        'script' => 'vendors/slick/slick.js',
                        'version' => '1.8.1',
                        'dependency' => array('jquery'),
                    ),
                );
                $scripts = apply_filters(self::get_block_name($this->slug) . '_frontend_assets', $scripts, $this);
                self::enqueue($scripts);
            }
        }

        /**
         * Generate & Print Frontend Styles
         * Called in wp_head hook
         * @access public
         * @since 1.0.0
         * @return null
         */
        public function prepare_scripts_styles()
        {   
            foreach ($this->blocks as $block) {

                $attrs = self::get_attrs_with_default($block['attrs']);
                $xs_css = array();
                $sm_css = array();

                # Typography for title, content on mobile
                $title_typo = self::get_initial_responsive_props();
                if (isset($attrs['titleTypography'])) {
                    $title_typo = self::get_typography_props($attrs['titleTypography']);
                }

                $content_typo = self::get_initial_responsive_props();
                if (isset($attrs['contentTypography'])) {
                    $content_typo = self::get_typography_props($attrs['contentTypography']);
                }

                $readmore_typo = self::get_initial_responsive_props();
                if (isset($attrs['readMoreTypography'])) {
                    $readmore_typo = self::get_typography_props($attrs['readMoreTypography']);
                }

                $height = self::get_initial_responsive_props();
                if (isset($attrs['height'])) {
                    $height = self::get_responsive_props($attrs['height'], 'height');
                }

                $border_radius = self::get_initial_responsive_props();
                if (isset($attrs['readMoreRadius'])) {
                    $border_radius = self::get_dimension_props('border-radius', $attrs['readMoreRadius']);
                }

                $container_width = self::get_initial_responsive_props();
                if (isset($attrs['width'])) {
                    $container_width = self::get_responsive_props($attrs['width'], 'max-width');
                }

                foreach (array('mobile', 'tablet', 'desktop') as $device) {
                    $css = array(
                        array(
                            'selector' => self::add_prefix('.%prefix-banner-title'),
                            'props' => $title_typo[$device],
                        ),
                        array(
                            'selector' => self::add_prefix('.%prefix-banner-text-content'),
                            'props' => $content_typo[$device],
                        ),
                        array(
                            'selector' => self::add_prefix('.%prefix-banner-caption .%prefix-banner-btn'),
                            'props' => $readmore_typo[$device],
                        ),
                        array(
                            'selector' => self::add_prefix('.%prefix-banner-has-bg'),
                            'props' => $height[$device],
                        ),
                        array(
                            'selector' => self::add_prefix('.%prefix-banner-caption'),
                            'props' => $container_width[$device],
                        ),
                    );

                    self::add_styles(array(
                        'attrs' => $attrs,
                        'css' => $css,
                    ), $device);
                }

                $dynamic_css = array(
                    array(
                        'selector' => self::add_prefix('.%prefix-banner-title'),
                        'props' => array(
                            'color' => 'titleColor',
                        ),
                    ),
                    array(
                        'selector' => self::add_prefix('.%prefix-banner-text-content'),
                        'props' => array(
                            'color' => 'contentColor',
                        ),
                    ),
                    array(
                        'selector' => self::add_prefix('.%prefix-banner-btn'),
                        'props' => array(
                            'background-color' => 'commonBgColor',
                            'color' => 'commonTextColor',
                        ),
                    ),
                    array(
                        'selector' => self::add_prefix('.%prefix-prev-arrow'),
                        'props' => array(
                            'background-color' => 'commonBgColor',
                            'border-color' => 'commonBgColor',
                        ),
                    ),
                    array(
                        'selector' => self::add_prefix('.%prefix-next-arrow'),
                        'props' => array(
                            'background-color' => 'commonBgColor',
                            'border-color' => 'commonBgColor',
                        ),
                    ),
                    array(
                        'selector' => self::add_prefix('.%prefix-prev-arrow'),
                        'props' => array(
                            'color' => 'commonTextColor',
                        ),
                    ),
                    array(
                        'selector' => self::add_prefix('.%prefix-next-arrow'),
                        'props' => array(
                            'color' => 'commonTextColor',
                        ),
                    ),
                    array(
                        'selector' => '.slick-dots li.slick-active button',
                        'props' => array(
                            'color' => 'commonBgColor',
                            'background' => 'commonBgColor',
                        ),
                    ),
                    array(
                        'selector' => '.slick-dots li button',
                        'props' => array(
                            'border-color' => 'commonBgColor',
                        ),
                    ),
                    array(
                        'selector' => '.slick-dots li button',
                        'props' => array(
                            'color' => 'commonTextColor',
                        ),
                    ),
                    array(
                        'selector' => self::add_prefix('.%prefix-banner-overlay'),
                        'props' => array(
                            'background-color' => 'sectionOverlayColor',
                        ),
                    ),
                    array(
                        'selector' => self::add_prefix('.%prefix-banner-btn'),
                        'props' => $border_radius['desktop'],
                    ),
                );

                self::add_styles(array(
                    'attrs' => $attrs,
                    'css' => $dynamic_css,
                ));

                $fade = 'false';
                if ($attrs['effect'] == 'fade' || $attrs['effect'] == 'fade-zoom') {
                    $fade = 'true';
                }

                ob_start();
                ?>

				var riseBlockSliderArgs = {
					slidesToShow: 1,
					slidesToScroll: true,
					autoplay: <?php echo $attrs['autoplay'] ? 'true' : 'false'; ?>,
					pauseOnHover: <?php echo $attrs['pauseOnHover'] ? 'true' : 'false'; ?>,
					infinite: <?php echo $attrs['infiniteLoop'] ? 'true' : 'false'; ?>,
					autoplaySpeed: <?php echo esc_attr($attrs['speed']) * 1000; ?>,
					arrows: <?php echo $attrs['enableArrow'] ? 'true' : 'false'; ?>,
					dots: <?php echo $attrs['enableDots'] ? 'true' : 'false'; ?>,
					prevArrow: '<button type="button" class="slick-prev <?php self::add_prefix_e('%prefix-prev-arrow %prefix-slider-arrow');?>"><i class="fa fa-angle-left"></i></button>',
					nextArrow: '<button type="button" class="slick-next <?php self::add_prefix_e('%prefix-next-arrow %prefix-slider-arrow');?>"><i class="fa fa-angle-right"></i></button>',
					adaptiveHeight: true,
					fade: <?php echo esc_attr($fade); ?>,
				};

				jQuery('#<?php echo esc_attr($attrs['block_id']) . ' ' . self::add_prefix('.%prefix-banner-slider-init'); ?>').slick( riseBlockSliderArgs );
				<?php
$js = ob_get_clean();
                self::add_scripts($js);
            }
        }

        /**
         * Returns attributes for this Block
         *
         * @access public
         * @since 1.0.0
         * @return array
         */
        protected function get_attrs()
        {
            return array(

                # Hidden setting
                'block_id' => array(
                    'type' => 'string',
                ),

                'tag' => array(
                    'type' => 'string',
                    'default' => 'h2',
                ),
                'page_id' => array(
                    'type' => 'string',
                ),

                'useExternalLink' => array(
                    'type' => 'boolean',
                ),

                # content setting
                'enableTitle' => array(
                    'type' => 'boolean',
                    'default' => true,
                ),
                'enableContent' => array(
                    'type' => 'boolean',
                    'default' => true,
                ),
                'enableArrow' => array(
                    'type' => 'boolean',
                    'default' => true,
                ),
                'enableDots' => array(
                    'type' => 'boolean',
                    'default' => true,
                ),
                'excerptLength' => array(
                    'type' => 'number',
                    'default' => 20,
                ),

                #slider Settings
                'autoplay' => array(
                    'type' => 'boolean',
                    'default' => true,
                ),
                'pauseOnHover' => array(
                    'type' => 'boolean',
                    'default' => true,
                ),
                'infiniteLoop' => array(
                    'type' => 'boolean',
                    'default' => true,
                ),
                'speed' => array(
                    'type' => 'number',
                    'default' => 5,
                ),
                'effect' => array(
                    'type' => 'string',
                    'default' => 'fade',
                ),

                # settings for readmore button
                'readMoreText' => array(
                    'type' => 'string',
                    'default' => esc_html__('Read More', 'rise-blocks'),
                ),
                'openTab' => array(
                    'type' => 'boolean',
                    'default' => true,
                ),
                'sectionClickable' => array(
                    'type' => 'boolean',
                    'default' => false,
                ),
                'readMoreRadius' => array(
                    'type' => 'object',
                    'default' => array(
                        'responsiveViews' => array('desktop'),
                        'units' => array('px'),
                        'activeUnit' => 'px',
                        'isLinkActive' => true,
                        'values' => array('desktop' => [0, 0, 0, 0]),
                    ),
                ),
                'height' => array(
                    'type' => 'object',
                    'default' => array(
                        'activeUnit' => 'vh',
                        'units' => array('px', 'vh'),
                        'values' => array('desktop' => 85, 'tablet' => 80, 'mobile' => 60),
                        'range' => array('min' => 1, 'max' => 2000),
                    ),
                ),
                'width' => array(
                    'type' => 'object',
                    'default' => array(
                        'activeUnit' => 'px',
                        'units' => array('px', 'vw'),
                        'values' => array('desktop' => 1140, 'tablet' => 720, 'mobile' => 540),
                        'range' => array('min' => 100, 'max' => 2000),
                    ),
                ),
                'titleTypography' => array(
                    'type' => 'object',
                    'default' => array(
                        'fontFamily' => 'Lato',
                        'fontSize' => array(
                            'units' => array('px', 'em', 'rem'),
                            'activeUnit' => 'px',
                            'values' => array(
                                'desktop' => 48,
                                'tablet' => 28,
                                'mobile' => 22,
                            ),
                        ),
                        'fontWeight' => 700,
                        'lineHeight' => array(
                            'activeUnit' => '',
                            'units' => array(''),
                            'values' => array(
                                'desktop' => 1.5,
                                'tablet' => 1.5,
                                'mobile' => 1.5,
                            ),
                        ),
                    ),
                ),
                'contentTypography' => array(
                    'type' => 'object',
                    'default' => array(
                        'fontFamily' => 'Lato',
                        'fontSize' => array(
                            'units' => array('px', 'em', 'rem'),
                            'activeUnit' => 'px',
                            'values' => array(
                                'desktop' => 18,
                                'tablet' => 18,
                                'mobile' => 18,
                            ),
                        ),
                        'fontWeight' => 400,
                        'lineHeight' => array(
                            'activeUnit' => '',
                            'units' => array(''),
                            'values' => array(
                                'desktop' => 1.8,
                                'tablet' => 1.8,
                                'mobile' => 1.8,
                            ),
                        ),
                    ),
                ),
                'readMoreTypography' => array(
                    'type' => 'object',
                    'default' => array(
                        'fontFamily' => 'Lato',
                        'fontSize' => array(
                            'units' => array('px', 'em', 'rem'),
                            'activeUnit' => 'rem',
                            'values' => array(
                                'desktop' => 0.9,
                                'tablet' => 0.9,
                                'mobile' => 0.9,
                            ),
                        ),
                        'fontWeight' => 400,
                        'lineHeight' => array(
                            'activeUnit' => '',
                            'units' => array(''),
                            'values' => array(
                                'desktop' => 1.5,
                                'tablet' => 1.5,
                                'mobile' => 1.5,
                            ),
                        ),
                    ),
                ),

                # Color Settings
                'titleColor' => array(
                    'type' => 'string',
                    'default' => self::$color_palette['white'],
                ),
                'sectionOverlayColor' => array(
                    'type' => 'string',
                    'default' => 'rgba(0, 0, 0, 0.3)',
                ),
                'contentColor' => array(
                    'type' => 'string',
                    'default' => self::$color_palette['white'],
                ),
                'commonBgColor' => array(
                    'type' => 'string',
                    'default' => self::$color_palette['white'],
                ),
                'commonTextColor' => array(
                    'type' => 'string',
                    'default' => self::$color_palette['black'],
                ),
            );
        }

        /**
         * Renders blocks in frontend
         *
         * @access public
         * @since 1.0.0
         * @return string
         */
        public function render($attrs, $content){

            $data = isset($attrs['page_id']) ? json_decode($attrs['page_id']) : false;
            if (!$data) {
                return false;
            }

            $ids = array();
            foreach ($data as $obj) {
                if (isset($obj->id)) {
                    $ids[] = absint($obj->id);
                }
            }

            $block_content = '';
            $args = array(
                'post_type' => 'page',
                'post_status' => 'publish',
                'post__in' => $ids,
                'orderby' => 'post__in',
            );

            $query = new WP_Query(apply_filters(self::add_prefix('%prefix_pageslider_query'), $args));
            $target = '';
            if ($attrs['openTab']) {
                $target = 'target="_blank"';
            }

            if ($query->have_posts()):
                ob_start();
                $index = 0;
                ?>
				<section id="<?php echo esc_attr($attrs['block_id']); ?>" class="<?php echo esc_attr($attrs['effect']) . ' ';
                self::add_prefix_e('%prefix-banner-section-wrapper'); ?>">
							<div class="<?php self::add_prefix_e('%prefix-page-slider-overlay');?>"></div>
							<div class="<?php self::add_prefix_e('%prefix-banner-slider-init');?>">
								<?php while ($query->have_posts()): ?>
									<?php $query->the_post();?>
									<?php
    $image = false;
                if (has_post_thumbnail()) {
                    $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                }

                if (isset($attrs['useExternalLink']) && $attrs['useExternalLink']) {
                    $link = isset($data[$index]->link) ? $data[$index]->link : '';
                } else {
                    $link = get_the_permalink();
                }

                $index++;
                ?>
									<div>
										<div
											<?php if ($image): ?>
												style="background: url('<?php echo esc_url($image); ?>') center center;"
											<?php endif;?>

									class="<?php self::add_prefix_e('%prefix-banner-has-bg');?>"
								>
									<div class="<?php self::add_prefix_e('%prefix-banner-overlay');?>"></div>
									<?php if ($attrs['sectionClickable']): ?>
										<a href="<?php echo esc_url($link); ?>" <?php echo esc_attr($target); ?>>
									<?php endif;?>
									<div class="<?php self::add_prefix_e('%prefix-banner-caption');?>">
										<div class="<?php self::add_prefix_e('%prefix-banner-content');?>">

											<<?php echo esc_attr($attrs['tag']); ?> class="<?php self::add_prefix_e('%prefix-banner-title');?>">
												<?php if ($attrs['enableTitle']) {the_title();}?>
											</<?php echo esc_attr($attrs['tag']); ?>>

											<?php if ($attrs['enableContent']): ?>
												<div class="<?php self::add_prefix_e('%prefix-banner-text-content');?>">
													<?php self::excerpt($attrs['excerptLength']);?>
												</div>
											<?php endif;?>

											<?php if (!$attrs['sectionClickable']): ?>
												<div class="<?php self::add_prefix_e('%prefix-banner-btn-group');?>">
											    	<a class="<?php self::add_prefix_e('%prefix-banner-btn');?>"
											    		href="<?php echo esc_url($link); ?>" <?php echo esc_attr($target); ?>>
											    		<?php echo esc_html($attrs['readMoreText']); ?>
											    	</a>
											    </div>
											<?php endif;?>

										</div>
									</div>
									<?php if ($attrs['sectionClickable']): ?>
										</a>
									<?php endif;?>
								</div>
							</div>
						<?php endwhile;?>
					</div>
				</section>
				<?php
wp_reset_postdata();
            $block_content = ob_get_clean();
            endif;

            return $block_content;
        }
    }
}

Rise_Blocks_Slider::get_instance()->init();
