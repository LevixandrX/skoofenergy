<?php
/**
 * Render Advanced Button block
 *
 * @since 1.0.3
 * @package Rise Block
 */

if (!class_exists('Rise_Blocks_Button')) {

    class Rise_Blocks_Button extends Rise_Blocks_Base
    {

        /**
         * Slug of the block.
         *
         * @access protected
         * @since 1.0.3
         * @var string
         */
        protected $slug = 'button';

        /**
         * Whether the block is insertable or not.
         *
         * Setting this variable to false will bypass in plugins landing page.
         * @access public
         * @since 1.0.3
         * @var string
         */
        public $inserter = false;

        /**
         * Title of this block.
         *
         * @access protected
         * @since 1.0.3
         * @var string
         */
        protected $title = '';

        /**
         * Description of this block.
         *
         * @access protected
         * @since 1.0.3
         * @var string
         */
        protected $description = '';

        /**
         * SVG Icon for this block.
         *
         * @access protected
         * @since 1.0.3
         * @var string
         */
        protected $icon = '';

        /**
         * link to the demo of this block.
         *
         * @access protected
         * @since 1.0.3
         * @var string
         */
        protected $demo_link = 'icon-box';

        /**
         * To store Array of this blocks that user adds
         *
         * @access protected
         * @since 1.0.3
         * @var array
         */
        protected $blocks = array();

        /**
         * The object instance.
         *
         * @static
         * @access protected
         * @since 1.0.3
         * @var object
         */
        private static $instance;

        /**
         * Gets an instance of this object.
         * Prevents duplicate instances which avoid artefacts and improves performance.
         *
         * @static
         * @access public
         * @since 1.0.3
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
         * Generate & Print Frontend Styles
         * Called in wp_head hook
         * @access public
         * @since 1.0.3
         * @return null
         */
        public function prepare_scripts_styles()
        {

            $this->get_blocks();

            foreach ($this->blocks as $block) {

                $attrs = $block['attrs'];
                $typo = self::get_typography_props($attrs['typo']);

                $icon_size = self::get_responsive_props($attrs['iconSize'], 'font-size');
                $padding = self::get_dimension_props('padding', $attrs['padding']);
                $margin = self::get_dimension_props('margin', $attrs['margin']);

                foreach (self::$devices as $device) {

                    $css = array(
                        array(
                            'selector' => self::add_prefix('.%prefix-advanced-button-text'),
                            'props' => $typo[$device],
                        ),
                        array(
                            'props' => array_merge($padding[$device], $margin[$device]),
                        ),
                    );

                    if ($attrs['enableIcon']) {
                        $css[] = array(
                            'selector' => self::add_prefix(' > i'),
                            'props' => $icon_size[$device],
                        );
                    }

                    self::add_styles(array(
                        'attrs' => $attrs,
                        'css' => $css,
                    ), $device);
                }

                $dynamic_css = array(
                    array(
                        'props' => array(
                            'border-radius' => 'radius',
                            'background-color' => 'buttonBackground',
                            'border-color' => 'buttonBorderColor',
                            'border-style' => ['value' => 'solid', 'unit' => ''],
                            'text-decoration' => ['value' => 'none', 'unit' => ''],
                            'border-width' => 'border',
                            'color' => 'buttonTextColor',
                        ),
                    ),
                    array(
                        'selector' => ':hover',
                        'props' => array(
                            'background-color' => 'buttonHoverBackground',
                            'border-color' => 'buttonHoverBorderColor',
                            'color' => 'buttonHoverTextColor',
                        ),
                    ),
                );

                self::add_styles(array(
                    'attrs' => $attrs,
                    'css' => $dynamic_css,
                ));
            }

        }
    }
}

Rise_Blocks_Button::get_instance()->init();
