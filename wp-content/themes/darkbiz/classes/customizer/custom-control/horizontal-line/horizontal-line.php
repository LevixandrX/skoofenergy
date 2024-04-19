<?php
/**
*
* A Custom control for post dropdown
*
* @since 1.0.0
*
* @package Darkbiz WordPress theme
*
* @uses  Class WP_Customize_Control
* 
*/
if ( class_exists( 'WP_Customize_Control' ) ) :

	class Darkbiz_Horizontal_Line extends WP_Customize_Control {

		public $type = 'darkbiz-horizontal-line';

		/**
		*    
		* Adds the horizontal line
		* @since  1.0.0
		* @access public
		* @return void   
		*  
		* @package Darkbiz WordPress Theme
		*/ 
		public function render_content() { ?>
			<style>
				hr{
					border-top: 7px solid #c1c1c1;
					border-bottom: 0;
				}
			</style>
			<div class="darkbiz-horizontal-line">
				<span class="customize-control-title"><?php echo esc_html( $this->label ) ?></span>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ) ?></span>
				<hr>
			</div>
		<?php }

	}

endif;

Darkbiz_Customizer::add_custom_control( array(
    'type'     => 'darkbiz-horizontal-line',
    'class'    => 'Darkbiz_Horizontal_Line',
    'sanitize' => false,
    'register_control_type' => false
));