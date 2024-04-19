<?php 
/**
 * Common css for all devices
 *
 * @since 1.0.0
 * @package Darkbiz WordPress Theme
 */

add_action( 'init', Darkbiz_Helper::fn_prefix( 'custom_width' ), 99 );
add_action( 'customize_preview_init', Darkbiz_Helper::fn_prefix( 'custom_width' ), 150 );

/**
 * Adjust custom width
 *
 * @since 1.0.0
 * @package Darkbiz WordPress Theme
 */
function darkbiz_custom_width(){
	// echo darkbiz_get( 'container-width' );die;
	if( 'default' == darkbiz_get( 'container-width' ) ) :
		# container width
		$style = array(
			array(
				'selector' => '.container',
				'props' => array(
					'max-width' => 'container-custom-width',
			)
		));

		Darkbiz_Css::add_styles( $style, 'md' );
	endif;

}

add_action( 'init', 'darkbiz_all_device_css' );
/**
 * Register dynamic css
 *
 * @since 1.0.0
 * @package Darkbiz WordPress Theme
 */
function darkbiz_all_device_css(){

	$style = array(
		# Primary Color
		array(
			'selector' => Darkbiz_Helper::with_prefix_selector( '.banner-slider-content .inner-banner-btn a, .pagination .nav-links > *.current, ::selection, %s-main-menu > ul > li > a:after, %s-btn-primary, #infinite-handle span, ul.wc-block-grid__products li.wc-block-grid__product button, ul.wc-block-grid__products li.wc-block-grid__product .wp-block-button__link, ul.wc-block-grid__products li.wc-block-grid__product button:hover, ul.wc-block-grid__products li.wc-block-grid__product .wp-block-button__link:hover, ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-onsale, .woocommerce ul.products li.product .button, .woocommerce ul.products li.product .added_to_cart.wc-forward,
				.woocommerce ul.products li.product .onsale, .single-product .product .onsale,
				 .single-product .product .entry-summary button.button, a.cart-icon span:hover, .darkbiz-dark-mode.woocommerce #review_form #respond .form-submit input,
				  .woocommerce-cart .woocommerce .cart-collaterals .cart_totals a.checkout-button.button.alt.wc-forward, 
				   .woocommerce-cart .woocommerce form.woocommerce-cart-form table button.button, .darkbiz-dark-mode .woocommerce button.button,
				   form.woocommerce-checkout div#order_review #payment button#place_order, .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
					.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .widget.woocommerce.widget_price_filter .price_slider_amount .button, .widget .woocommerce-product-search button, .woocommerce ul.products li.product-category.product h2,
					  #site-navigation li.menu-item:before, div#mr-mobile-menu li.menu-item:before'
			 ),
			'props' => array(
				'background-color' => 'primary-color',
			)
		),
		
		array(
			'selector' => Darkbiz_Helper::with_prefix_selector( '.product-with-slider %s-arrow svg, .product-with-slider %s-arrow svg:hover' ),
			'props' => array(
				'fill' => 'primary-color',
			)
		),		
		array(
			'selector' => Darkbiz_Helper::with_prefix_selector(  '#infinite-handle span, .darkbiz-dark-mode .woocommerce-info a:hover,
			.post-content-wrap .post-categories li a:hover, %s-post .entry-content-stat + a:hover, %s-post %s-comments a:hover, %s-bottom-header-wrapper %s-header-icons %s-search-icon, .pagination .nav-links > *, body .post-categories li a, ul.wc-block-grid__products li.wc-block-grid__product del span.woocommerce-Price-amount.amount, .woocommerce ul.products li.product a.woocommerce-LoopProduct-link del span.woocommerce-Price-amount.amount, 
			ul.wc-block-grid__products li.wc-block-grid__product del, .woocommerce ul.products li.product .star-rating, 
			ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-title a:hover, 
			.single-product .product .entry-summary .product_meta > span a, .single-product .stars a, 
			.single-product .star-rating span::before, .darkbiz-dark-mode .darkbiz-main-menu > ul > li > a:hover,
			.wc-block-grid__product-rating .wc-block-grid__product-rating__stars span:before, .woocommerce-error::before,
			.single-product .product .entry-summary .star-rating span::before, .single-product .product .entry-summary a.woocommerce-review-link, 
			.woocommerce .star-rating, .woocommerce del, li.wc-layered-nav-rating a, .darkbiz-dark-mode .footer-widget ul li a:hover, 
			.woocommerce ul.products li.product-category.product h2 mark.count,  .cart-icon i:hover,
			.site-branding .site-title a:hover, .footer-bottom-section .credit-link a:hover,
			.darkbiz-dark-mode .darkbiz-post .post-title a:hover, .darkbiz-dark-mode a:hover .woocommerce-privacy-policy-link,
			.darkbiz-dark-mode .post-content-wrap p > a:hover, .darkbiz-search-icons:visited:hover,
			.darkbiz-dark-mode .comment-respond .logged-in-as a:hover, .post-navigation .nav-links > div a:hover span,
			.post-navigation .nav-links > div a .screen-reader-text:hover, .entry-meta.single .url:hover,
			.comments-area .comment-list .comment-body .comment-author cite a:hover, .woocommerce-message::before,
			.footer-widget ul li a:hover, .darkbiz-dark-mode .product-name a:hover,  .product-name a:hover, .darkbiz-dark-mode .darkbiz-main-menu > ul > li > ul li a:hover,
			.footer-widget a:hover, .wrap-breadcrumb ul li a:hover, .wrap-breadcrumb ul li a span:hover, #secondary .widget a:hover, #secondary .widget ul li a:hover,
			.woocommerce ul.products li.product a.woocommerce-LoopProduct-link .woocommerce-loop-product__title:hover,.mr-mobile-menu ul.menu > li > a:hover,
			.mr-mobile-menu ul.menu > li > a:focus, a:hover .woocommerce-privacy-policy-link, a:focus .woocommerce-privacy-policy-link' ),
			'props' => array(
				'color' => 'primary-color',
			)
		),
		array(
			'selector' => Darkbiz_Helper::with_prefix_selector( '.pagination .nav-links > *, %s-post.sticky,
			.darkbiz-dark-mode .woocommerce-message, .darkbiz-dark-mode .woocommerce-error, .darkbiz-dark-mode .woocommerce-info, 
			.woocommerce .woocommerce-customer-details address' ),
			'props' => array(
				'border-color' => 'primary-color',
			)
		),

		# Typography
		array(
			'selector' => '.site-branding .site-title, .site-branding .site-description, .site-title a',
			'props'    => array(
				'font-family' => 'site-info-font'
			)
		),
		array(
			'selector' => 'body',
			'props'    => array(
				'font-family' => 'body-font'
			)
		),
		array(
			'selector'  => 'h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a',
			'props'	=> array(
				'font-family' => 'heading-font',
			),
		),
		# Color Options
		array(
			'selector'  => 'body, body p, body div, .woocommerce-Tabs-panel, div#tab-description, .woocommerce-tabs.wc-tabs-wrapper',
			'props'		=> array(
				'color' => 'body-paragraph-color',
			),
		),
		array(
			'selector'  => Darkbiz_Helper::with_prefix_selector( '%s-main-menu > ul > li > a, .darkbiz-main-menu > ul > li > a, .darkbiz-search-opened .darkbiz-header-search .close, %s-search-icons, %s-search-icons:visited' ),
			'props'		=> array(
				'color' => 'primary-menu-item-color',
			),
		),
		array(
			'selector'  => 'body a, body a:visited',
			'props'		=> array(
				'color' => 'link-color',
			),
		),
		array(
			'selector'  => 'body a:hover',
			'props'		=> array(
				'color' => 'link-hover-color',
			),
		),
		array(
			'selector'  => '#secondary .widget-title',
			'props'		=> array(
				'color' => 'sb-widget-title-color',
			),
		),		
		array(
			'selector'  => '#secondary .widget, #secondary .widget a, #secondary .widget ul li a',
			'props'		=> array(
				'color' => 'sb-widget-content-color',
			),
		),
		array(
			'selector'  => '.footer-widget .widget-title',
			'props'		=> array(
				'color' => 'footer-title-color',
			),
		),
		array(
			'selector'  => '.footer-top-section',
			'props'		=> array(
				'background-color' => 'footer-top-background-color',
			),
		),		
		array(
			'selector'  => '.footer-bottom-section',
			'props'		=> array(
				'background-color' => 'footer-copyright-background-color',
			),
		),		
		array(
			'selector'  => '.footer-widget, .footer-widget span, .footer-widget ul li a,  #calendar_wrap #wp-calendar th, #calendar_wrap td, #calendar_wrap caption, #calendar_wrap td a,  .footer-widget ul li',
			'props'		=> array(
				'color' => 'footer-content-color',
			),
		),
		array(
			'selector'  => '.footer-bottom-section span, .footer-bottom-section .credit-link',
			'props'		=> array(
				'color' => 'footer-copyright-text-color',
			),
		),		
		# inner banner
		array(
			'selector' => Darkbiz_Helper::with_prefix_selector( '%s-inner-banner-wrapper:after' ),
			'props'    => array(
				'background-color' => 'ib-background-color'
			)
		),
		array(
			'selector' => Darkbiz_Helper::with_prefix_selector( '%s-inner-banner-wrapper %s-inner-banner .entry-title' ),
			'props'    => array(
				'color' => 'ib-title-color'
			)
		),
		# Breadcrumb
		array(
			'selector'  => '.wrap-breadcrumb ul.trail-items li a:after',
			'props'		=> array(
				'content' => 'bc-separator',
			),
		),
		array(
			'selector'  => '.wrap-breadcrumb ul li a, .wrap-breadcrumb ul li span, .taxonomy-description p',
			'props'		=> array(
				'color' => 'ib-title-color'
			),
		),
	);

	Darkbiz_Css::add_styles( $style, 'md' );
}