<?php
/**
 * A class to setting up the things
 *
 * @see https://wordpress.org/gutenberg/handbook/
 * @since 1.0.0
 */

if (!class_exists('Rise_Blocks_Init')) {
    /**
     * Class Rise_Blocks_Init.
     */
    class Rise_Blocks_Init extends Rise_Blocks_Helper{

        /**
         * Register necessarry styles and scripts for plugin
         * Register custom category
         *
         * @access public
         * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/javascript/loading-javascript/
         * @uses register_scripts()
         * @return void
         * @since 1.0.0
         */
        public function __construct(){

            add_action('enqueue_block_assets', array(__CLASS__, 'block_assets'));

            add_action('rest_api_init', array(__CLASS__, 'register_rest_fields'));

            if (version_compare($GLOBALS['wp_version'], '5.8-alpha-1', '<')) {
                add_filter('block_categories', array(__CLASS__, 'register_category'), 10, 2);
            } else {
                add_filter('block_categories_all', array(__CLASS__, 'register_category'), 10, 2);
            }

            self::includes(array('admin', 'header', 'footer'));

            add_action('plugins_loaded', array(__CLASS__, 'include_files'));

            add_action('customize_register', array(__CLASS__, 'customize_register'));

            add_action('widgets_init', array(__CLASS__, 'widgets_init'));

            add_action('get_header', array(__CLASS__, 'override_header'));
            add_action('get_footer', array(__CLASS__, 'override_footer'));

            add_filter('register_taxonomy_args', array(__CLASS__, 'show_menu_in_rest'), 10, 3);
            add_action('rest_api_init', function () {
                register_rest_route('rise-blocks', '/nav-menu-item/', array(
                    'methods' => 'GET',
                    'callback' => array($this, 'get_menu'),
                    'permission_callback' => function () {return true;},
                ));
            });

            add_filter('block_categories_all', function ($categories) {
                # setup category array
                $category = [
                    'slug' => 'rise-blocks',
                    'title' => __('Rise Blocks', 'rise-blocks'),
                ];

                # make a new category array and insert ours at position 1
                $new_categories = [];
                $new_categories[0] = $category;

                # rebuild cats array
                foreach ($categories as $category) {
                    $new_categories[] = $category;
                }

                return $new_categories;
            }, 9999, 1);
        }

        public function get_menu(){

            $terms = get_terms(array(
                'taxonomy' => 'nav_menu',
            ));

            $data = array();
            if (is_array($terms)) {
                foreach ($terms as $t) {
                    $data[$t->term_id] = wp_get_nav_menu_items($t->term_id);
                }
            }

            return $data;
        }

        public static function show_menu_in_rest($args, $name, $object)
        {

            if ('nav_menu' == $name) {
                $args['show_in_rest'] = true;
            }

            return $args;
        }

        public static function override_header()
        {

            $header = get_theme_mod('rise-blocks-header', false);
            if (!$header) {
                return;
            }

            require_once plugin_dir_path(Rise_Blocks_File) . 'header.php';

            $templates = [];
            $templates[] = 'header.php';

            // Avoid running wp_head hooks again.
            remove_all_actions('wp_head');
            ob_start();
            locate_template($templates, true);
            ob_get_clean();
        }

        public static function override_footer()
        {

            $footer = get_theme_mod('rise-blocks-footer', false);
            if (!$footer) {
                return;
            }

            require_once plugin_dir_path(Rise_Blocks_File) . 'footer.php';

            $templates = [];
            $templates[] = 'footer.php';

            // Avoid running wp_head hooks again.
            remove_all_actions('wp_footer');
            ob_start();
            locate_template($templates, true);
            ob_get_clean();
        }

        public static function widgets_init(){
            $header = get_theme_mod('rise-blocks-header', false);
            if ($header) {
                register_sidebar(array(
                    'name' => __('Rise Blocks Header', 'rise-blocks'),
                    'id' => 'rise-blocks-header',
                    'description' => __('Widgets in this area will be shown on Header of the page.', 'rise-blocks'),
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h2 class="widgettitle">',
                    'after_title' => '</h2>',
                ));
            }

            $footer = get_theme_mod('rise-blocks-footer', false);
            if ($footer) {
                register_sidebar(array(
                    'name' => __('Rise Blocks footer', 'rise-blocks'),
                    'id' => 'rise-blocks-footer',
                    'description' => __('Widgets in this area will be shown on Footer of the page.', 'rise-blocks'),
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h2 class="widgettitle">',
                    'after_title' => '</h2>',
                ));
            }
        }

        public static function customize_register($wp_customize){

            $wp_customize->add_setting('rise-blocks-environment', array(
                'default' => 'production',
                'transport' => 'refresh',
            ));

            $wp_customize->add_section('rise-blocks-general-section', array(
                'title' => __('Rise Blocks', 'rise-blocks'),
                'priority' => 30,
            ));

            $wp_customize->add_control('rise-blocks-environment', array(
                'label' => __('Mode', 'rise-blocks'),
                'type' => 'select',
                'choices' => array(
                    'production' => __('Production', 'rise-blocks'),
                    'development' => __('Development', 'rise-blocks'),
                ),
                'section' => 'rise-blocks-general-section',
            ));

            $wp_customize->add_setting('rise-blocks-header', array(
                'default' => false,
                'transport' => 'refresh',
            ));

            $wp_customize->add_control('rise-blocks-header', array(
                'label' => __('Enable Header Widget', 'rise-blocks'),
                'type' => 'checkbox',
                'section' => 'rise-blocks-general-section',
            ));

            $wp_customize->add_setting('rise-blocks-footer', array(
                'default' => false,
                'transport' => 'refresh',
            ));

            $wp_customize->add_control('rise-blocks-footer', array(
                'label' => __('Enable Footer Widget', 'rise-blocks'),
                'type' => 'checkbox',
                'default' => false,
                'section' => 'rise-blocks-general-section',
            ));
        }

        public static function include_files(){

            self::includes(array(
                'base',
                'heading',
                'slider',
                'icon-list',
                'icon-lists',
                'section',
                'call-to-action',
                'blog',
                'counter',
                'icon-boxes',
                'icon-box',
                'profile-cards',
                'profile-card',
                'buttons',
                'button',
                'social-icons',
                'social-icon',
                'accordion',
                'accordion-item',
                'news-1',
                'carousel-post',
                'site-identity',
                'navigation-menu',
                'image-slider',
                'image-text-slider',
            ), 'classes/blocks');

            self::includes(array(
                'marketplace',
            ), 'classes/marketplace');
        }

        /**
         * Register rest fields
         *
         * @access public
         * @return void
         * @since 1.0.0
         */
        public static function register_rest_fields(){

            # Add comment info.
            register_rest_field(
                'post',
                self::add_prefix('%prefix_total_comments'),
                array(
                    'get_callback' => array(__CLASS__, 'get_total_comment'),
                    'update_callback' => null,
                    'schema' => null,
                )
            );

            register_rest_field(
                'post',
                self::add_prefix('%prefix_categories'),
                array(
                    'get_callback' => array(__CLASS__, 'get_categories'),
                    'update_callback' => null,
                    'schema' => null,
                )
            );

            register_rest_field(
                'post',
                self::add_prefix('%prefix_excerpt'),
                array(
                    'get_callback' => array(__CLASS__, 'get_excerpt'),
                    'update_callback' => null,
                    'schema' => null,
                )
            );

            register_rest_field(
                'page',
                self::add_prefix('%prefix_excerpt'),
                array(
                    'get_callback' => array(__CLASS__, 'get_excerpt'),
                    'update_callback' => null,
                    'schema' => null,
                )
            );
        }

        /**
         * Register category
         *
         * @access public
         * @uses array_merge
         * @return array
         * @since 1.0.0
         */
        public static function register_category($categories, $post)
        {
            return array_merge($categories, array(
                array(
                    'slug' => self::get_prefix(),
                    'title' => esc_html__('Rise Blocks', 'rise-blocks'),
                ),
            ));
        }

        /**
         * Register Style for banckend and frontend
         * dependencies { wp-editor }
         * @access public
         * @return void
         * @since 1.0.0
         */
        public static function block_assets(){

            $scripts = array(
                array(
                    'handler' => 'font-awesome',
                    'style' => 'vendors/font-awesome/css/font-awesome.css',
                    'version' => '4.7.0',
                ),
                array(
                    'handler' => self::add_prefix('%prefix-style-css'),
                    'style' => 'styles/style.css',
                    'minified' => false,
                    'version' => self::get_version(),
                ),
            );

            wp_enqueue_script('jquery');

            self::enqueue($scripts);

            if (is_admin()) {
                $scripts = array(
                    array(
                        'handler' => self::add_prefix('%prefix-editor-css'),
                        'style' => 'styles/editor.css',
                        'minified' => false,
                        'version' => self::get_version(),
                    ),
                    array(
                        'handler' => self::add_prefix('%prefix-fonts'),
                        'style' => 'https://fonts.googleapis.com/css?family=' . join('|', self::get_fonts()) . '&display=swap',
                        'absolute' => true,
                        'minified' => true,
                    ),
                );

                self::enqueue($scripts);

                $size = get_intermediate_image_sizes();
                $size[] = 'full';

                $l10n = apply_filters(self::add_prefix('%prefix_l10n'), array(
                    'image_size' => $size,
                    'plugin_path' => self::get_plugin_directory_uri(),
                ));

                wp_localize_script(self::add_prefix('%prefix-heading-editor-script'), 'Rise_Blocks_VAR', $l10n);
            }
        }
    }

    new Rise_Blocks_Init();
}
