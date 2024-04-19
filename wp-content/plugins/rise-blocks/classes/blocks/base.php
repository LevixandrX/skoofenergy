<?php
/**
 * Helper class for block
 *
 * @since 1.0.0
 * @package Rise Blocks
 */
if (!class_exists('Rise_Blocks_Base')):
    abstract class Rise_Blocks_Base extends Rise_Blocks_Helper{

        /**
         * Prevent some functions to called many times
         * @access private
         * @since 1.0.0
         * @var integer
         */
        private static $counter = 0;

        /**
         * store all the fonts that are used blocks
         *
         * @var array
         */
        protected static $fonts = array(
            # Lato is a default font for this plugin
            'Lato' => 'Lato:300,400,700,900',
        );

        public static $fse_content = '';

        public static $all_blocks = [];

        public static $block_list_names = [];

        /**
         * Store arrays of css and selectors
         *
         * @static
         * @access protected
         * @since 1.0.0
         */
        protected static $styles = array('mobile' => array(), 'tablet' => array(), 'desktop' => array());

        /**
         * Store arrays of inline scripts
         *
         * @static
         * @access protected
         * @since 1.0.0
         */
        protected static $scripts = array();

        /**
         * Initialize Block
         *
         * @static
         * @access public
         * @since 1.0.0
         * @return null
         */
        public function init(){ 

            $this->add_block();

            remove_filter( 'the_content', 'wpautop' );

            if( isset( $this->is_pro ) && $this->is_pro ){
                add_action( 'init', array( $this, 'register' ), 10 );
            }else{
                add_action( 'init', array( $this, 'register' ), 20 );
            }
            

            if( method_exists( $this, 'enqueue_scripts_styles' ) ){
                add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
            }

            if( method_exists( $this, 'block_assets' ) ){
                add_action( 'enqueue_block_assets', array( $this, 'block_assets' ) );
            }

            if( method_exists( $this, 'prepare_scripts_styles' ) ){
                add_action( self::get_block_name( $this->slug ) . '_run_prepared_scripts_styles', array( $this, 'prepare_scripts_styles' ) );
                add_action('wp_enqueue_scripts', array( $this, 'init_prepared_scripts_styles' ) );
            }

            if( self::$counter === 0 ){
                add_action( 'wp_head', array( __CLASS__, 'inline_scripts_styles' ), 99 );
                add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_fonts' ), 99 );
                self::$counter++;
            }
        }

        /**
         * This is called on wp_enqueue_scripts hook
         *
         * @since 1.0.0
         * @return null
         */
        public function init_prepared_scripts_styles(){
            do_action( self::get_block_name( $this->slug ) . '_run_prepared_scripts_styles', $this );
        }

        /**
         * Enqueue fonts
         *
         * @access public
         * @return void
         * @since 1.0.0
         */
        public static function enqueue_fonts(){
            $scripts = array(
                array(
                    'handler' => self::add_prefix('%prefix-fonts'),
                    'style' => '//fonts.googleapis.com/css?family=' . join('|', self::$fonts) . '&display=swap',
                    'absolute' => true,
                    'minified' => false,
                ),
            );
            self::enqueue($scripts);
        }

        /**
         * store font to its variable
         *
         * @param string $key
         * @return void
         */
        protected static function add_font($key){
            $f = self::get_fonts();
            if (isset($f[$key])) {
                self::$fonts[$key] = $f[$key];
            }
        }

        /**
         * Add styes to the array
         *
         * @static
         * @access protected
         * @since 1.0.0
         * @return null
         */
        protected static function add_styles($style, $device = 'desktop'){
            self::$styles[$device][] = $style;
        }

        /**
         * Add styes to the array
         *
         * @static
         * @access protected
         * @since 1.0.0
         * @return null
         */
        protected static function add_scripts($scripts){
            self::$scripts[] = $scripts;
        }

        /**
         * Print all the  styes scripts
         *
         * @static
         * @access public
         * @since 1.0.0
         * @return null
         */
        public static function process_css($styles){

            if (count($styles) > 0) {
                foreach ($styles as $style) {
                    $wrapper = isset($style['wrapper_selector']) ? $style['wrapper_selector'] : '#';
                    self::generate_css($style['css'], $style['attrs'], $wrapper);
                }
            }
        }

        /**
         * Print all the  styes scripts
         *
         * @static
         * @access public
         * @since 1.0.0
         * @return null
         */
        public static function inline_scripts_styles(){
            $styles = apply_filters('rise-blocks/styles', self::$styles);
            $scripts = apply_filters('rise-blocks/scripts', self::$scripts);
            ?>
            <style type="text/css" media="all" id="<?php echo esc_attr(self::add_prefix('%prefix-block-styles')) ?>">
                <?php self::process_css($styles['desktop']);?>

                @media (max-width: 991px) {
                    <?php self::process_css($styles['tablet']);?>
                }

                @media (max-width: 767px) {
                    <?php self::process_css($styles['mobile']);?>
                }
            </style>
            <?php

            if (count($scripts) > 0):
                ?>
                <script>
                    jQuery( document ).ready(function(){
                        <?php
                        # https://developer.wordpress.org/apis/security/escaping/#toc_4
                        foreach ($scripts as $script_escaped) {
                            echo $script_escaped;
                        }
                        ?>
                    });
                </script>
                <?php
            endif;
        }

    /**
     * Register this Block
     *
     * @access public
     * @since 1.0.0
     * @return null
     */
    public function register(){

        $param = array();

        if (method_exists($this, 'get_attrs')) {
            $param['render_callback'] = array($this, 'render');
            $param['attributes'] = $this->get_attrs();
        }

        $name = self::get_block_name($this->slug);
        $param = apply_filters($name . '_register', $param);
        if( isset( $this->is_pro ) && $this->is_pro ){
            $block_path = Rise_Blocks_Pro_Dir . '/build/blocks/' . $this->slug;
        }else{
            $block_path = Rise_Blocks_Dir . '/build/blocks/' . $this->slug;
        }
        register_block_type( $block_path, $param );

        if (method_exists($this, 'register_meta')) {
            $this->register_meta();
        }
    }

    /**
     * Returns array of the specific blocks from the content
     *
     * @access protected
     * @since 1.0.0
     * @return array
     */
    protected function get_blocks(){

        if (count(self::$all_blocks) == 0) {
            self::set_blocks();
        }

        foreach (self::$all_blocks as $block) {
            if (self::get_block_name($this->slug) == $block['blockName']) {
                $this->blocks[] = $block;
            }
        }

        return $this->blocks;
    }

    public static function set_fse_content(){

        $query = new WP_Query(array(
            'post_type' => [ 'wp_block', 'wp_template' ],
            'posts_per_page' => -1,
        ));

        if( $query->have_posts() ) {
            while( $query->have_posts() ){
                $query->the_post();
                $id = get_the_ID();
                self::$fse_content .= get_post_field( 'post_content', $id );
            }
        }

        wp_reset_postdata();

        $widget_blocks = get_option( 'widget_block' );

        if( is_array( $widget_blocks ) ){
            foreach( $widget_blocks as $wb ){
                if( is_array( $wb ) && isset( $wb[ 'content' ] ) ){
                    self::$fse_content .= $wb[ 'content' ];
                }
            }
        }
    }

    public static function get_block_list_names(){

        if( empty( self::$block_list_names ) ){
            foreach( self::$block_list as $l ){
                self::$block_list_names[] = $l[ 'name' ];
            }
        }

        return self::$block_list_names;
    }

    /**
     * Set array of the specific blocks from the content in blocks variable
     *
     * @access protected
     * @since 1.0.0
     * @return array
     */
    public static function set_blocks( $blocks = false ){

        if( !$blocks ){

            $id = get_the_ID();
            $content = get_post_field( 'post_content', $id );

            if( empty( self::$fse_content ) ){
                self::set_fse_content();
                $content .= self::$fse_content;
            }

            // Add support for patterns
            if( class_exists( 'WP_Block_Patterns_Registry' ) ){
                $patterns = WP_Block_Patterns_Registry::get_instance()->get_all_registered();
                foreach( $patterns as $pattern ){
                    $content .= $pattern[ 'content' ];
                }
            }

            $blocks = parse_blocks( $content );
        }

        $block_list_names = self::get_block_list_names();

        if( $blocks && count( $blocks ) > 0 ){
            foreach( $blocks as $block ){

                if( in_array( $block[ 'blockName' ], $block_list_names ) ){
                    self::$all_blocks[] = $block;
                }

                if( self::get_block_name( 'blog' ) == $block[ 'blockName' ] ){

                    $attrs = $block[ 'attrs' ];
                    if( isset( $attrs[ 'enableFullContent' ] ) && $attrs[ 'enableFullContent' ] == 1 ){

                        $blog = Rise_Blocks_Blog::get_instance();
                        $attrs = $blog->get_attrs_with_default($attrs);

                        $query = $blog->get_query($attrs);

                        while ($query->have_posts()) {
                            $query->the_post();
                            self::set_blocks(false);
                        }

                        wp_reset_postdata();
                    }
                }

                if( isset( $block[ 'innerBlocks' ] ) && count( $block[ 'innerBlocks' ] ) > 0 ){
                    self::set_blocks( $block[ 'innerBlocks' ] );
                }
            }
        }
    }

    /**
     * Enqueue Scripts in frontend after checking the existence of block in the content
     * Enqueues at backend regardless of condition
     * @access protected
     * @since 1.0.0
     * @return void
     */
    protected function enqueue_block_assets( $scripts, $blocks = false ){

        $scripts = apply_filters(self::get_block_name($this->slug) . '_block_assets', $scripts);

        if (!is_admin()) {
            $blocks = $this->get_blocks();
        }

        if (is_admin() || count($blocks) > 0) {
            self::enqueue($scripts);
        }
    }

    /**
     * Get unit for css property
     *
     * @access protected
     * @since 1.0.0
     * @return string
     */
    protected static function get_css_unit($prop){
        switch ($prop) {

            case 'font-size':
            case 'margin-top':
            case 'margin-bottom':
            case 'margin-left':
            case 'margin-right':
            case 'padding-top':
            case 'padding-bottom':
            case 'padding-left':
            case 'padding-right':
            case 'border-radius':
            case 'border-width':
            return 'px';
            default:
            return;

        }
    }

    /**
     * get compatible array for responsive control
     *
     * @access protected
     * @since 1.0.0
     * @return array
     */
    public static function get_initial_responsive_props(){
        return array(
            'mobile' => array(),
            'tablet' => array(),
            'desktop' => array(),
        );
    }

    /**
     * get compatible array from the value of responsive control
     *
     * @access protected
     * @since 1.0.0
     * @return array
     */
    public static function get_responsive_props($attr, $prop, $devices = false){

        $props = $devices ? $devices : array(
            'mobile' => array(),
            'tablet' => array(),
            'desktop' => array(),
        );

        if ($attr) {
            foreach ($props as $device => $a) {
                if ($attr['values'] && $attr['values'][$device]) {
                    $props[$device][$prop] = array(
                        'unit' => $attr['activeUnit'],
                        'value' => $attr['values'][$device],
                    );
                }
            }
        }

        return $props;
    }

    /**
     * get compatible array from the value of typography control
     *
     * @access protected
     * @since 1.0.0
     * @return array
     */
    public static function get_typography_props($typo, $devices = false){

        $props = $devices ? $devices : array(
            'mobile' => array(),
            'tablet' => array(),
            'desktop' => array(),
        );

        if ($typo) {

            foreach ($props as $device => $a) {

                if (isset($typo['fontSize'])) {
                    $title_size = $typo['fontSize'];
                    $props[$device]['font-size'] = array(
                        'unit' => $title_size['activeUnit'],
                        'value' => $title_size['values'][$device],
                    );
                }

                if (isset($typo['fontWeight'])) {

                    $props[$device]['font-weight'] = array(
                        'unit' => '',
                        'value' => $typo['fontWeight'],
                    );
                }

                if ($device == 'desktop') {

                    if (isset($typo['fontFamily'])) {
                        $props[$device]['font-family'] = array(
                            'unit' => '',
                            'value' => $typo['fontFamily'],
                        );
                    }

                    if (isset($typo['textTransform'])) {
                        $props[$device]['text-transform'] = array(
                            'value' => $typo['textTransform'],
                            'unit' => '',
                        );
                    }
                }

                if (isset($typo['lineHeight'])) {

                    $title_lh = $typo['lineHeight'];

                    $props[$device]['line-height'] = array(
                        'unit' => $title_lh['activeUnit'],
                        'value' => $title_lh['values'][$device],
                    );
                }
            }
        }

        self::add_font($props['desktop']['font-family']['value']);
        return $props;
    }

    /**
     * get compatible array from the value of dimension control
     *
     * @access protected
     * @since 1.0.0
     * @return array
     */
    public static function get_dimension_props($props, $attr, $devices = ['mobile', 'tablet', 'desktop']){

        if (!is_array($props)) {
            switch ($props) {
                case 'margin':
                $props = array(
                    'margin-top',
                    'margin-right',
                    'margin-bottom',
                    'margin-left',
                );
                break;
                case 'padding':
                $props = array(
                    'padding-top',
                    'padding-right',
                    'padding-bottom',
                    'padding-left',
                );
                break;
                case 'border-radius':
                $props = array(
                    'border-top-left-radius',
                    'border-top-right-radius',
                    'border-bottom-left-radius',
                    'border-bottom-right-radius',
                );
            }
        }

        $data = [];

        foreach ($devices as $device) {
            $data[$device] = array();
            foreach ($props as $i => $prop) {
                if (isset($attr['values'][$device])) {
                    $data[$device][$prop] = array(
                        'unit' => $attr['activeUnit'],
                        'value' => $attr['values'][$device][$i],
                    );
                }
            }
        }

        return $data;
    }

    /**
     * get compatible array for dimension control if attribute is null
     *
     * @access public
     * @since 1.0.0
     * @return array
     */
    public static function get_dimension_attr($attr, $v = 15, $unit = 'px'){

        if (is_null($attr)) {
            $attr = array(
                'values' => array(
                    'desktop' => array($v, $v, $v, $v),
                    'tablet' => array($v, $v, $v, $v),
                    'mobile' => array($v, $v, $v, $v),
                ),
                'activeUnit' => $unit,
            );
        }

        return $attr;
    }

    /**
     * print out the css
     *
     * @access protected
     * @since 1.0.0
     * @return void
     */
    protected static function generate_css($dynamic_css, $attrs, $wrapper_selector){

        if (count($dynamic_css) <= 0) {
            return;
        }

        foreach ($dynamic_css as $css) {

            $p = '';
            foreach ($css['props'] as $prop => $setting) {

                $unit = null;
                if (is_array($setting)) {
                    $value = isset($setting['value']) ? $setting['value'] : '';
                    $unit = isset($setting['unit']) ? $setting['unit'] : '';

                } else {
                    $value = isset($attrs[$setting]) ? esc_attr($attrs[$setting]) : '';
                }

                if (0 === $value || !empty($value)) {
                    $unit = isset($unit) ? $unit : self::get_css_unit($prop);
                    $p .= $prop . ': ' . $value . $unit . ';';
                }
            }
            if (!empty($p)) {
                $selector = '';

                if (isset($css['selector'])) {
                    if (is_array($css['selector'])) {

                        foreach ($css['selector'] as $s) {
                            $glue = substr($s, 0, 1) == ':' ? '' : ' ';
                            $selector .= $wrapper_selector . $attrs['block_id'] . $glue . $s . ',';
                        }

                        $selector = rtrim($selector, ',');
                    } else {

                        $selector = $wrapper_selector . $attrs['block_id'];
                        if (substr($css['selector'], 0, 1) == ':') {
                            $selector .= $css['selector'];
                        } else {
                            $selector .= ' ' . $css['selector'];
                        }
                    }
                } else {
                    $selector = $wrapper_selector . $attrs['block_id'];
                }

                $selector_escaped = self::add_prefix($selector);
                $selector_escaped .= '{' . $p . '}';
                echo $selector_escaped;

            }
        }
    }

    /**
     * merge attribute array with default values
     *
     * @access protected
     * @since 1.0.0
     * @return array
     */
    protected function get_attrs_with_default($attrs){

        $return = array();
        $def = array();
        if (method_exists($this, 'get_attrs')) {
            $def = $this->get_attrs();
        } else {
            return $attrs;
        }

        foreach ($def as $key => $val) {

            if (isset($attrs[$key])) {
                $return[$key] = $attrs[$key];
            } else {
                if (isset($def[$key]['default'])) {
                    $return[$key] = $def[$key]['default'];
                } else {
                    $return[$key] = false;
                }
            }
        }

        return $return;
    }
}
endif;