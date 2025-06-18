<?php

/**
 * WooCommerce customizations.
 */

/**
 * Dequeue default WooCommerce stylesheets on the front end.
 * Path of stylesheets: 'wp-content/plugins/woocommerce/assets/css/'
 *
 * This method works for styles specifically added via the 'woocommerce_enqueue_styles' filter.
 *
 * @link https://woocommerce.com/document/disable-the-default-stylesheet/
 * @see 'wp-content/plugins/woocommerce/includes/class-wc-frontend-scripts.php'
 */
function themeslug_dequeue_wooocommerce_styles($enqueue_styles) {
	unset($enqueue_styles['woocommerce-smallscreen']);
	unset($enqueue_styles['woocommerce-layout']);
	unset($enqueue_styles['woocommerce-blocktheme']);
	unset($enqueue_styles['woocommerce-general']);

	return $enqueue_styles;
}
add_filter('woocommerce_enqueue_styles', 'themeslug_dequeue_wooocommerce_styles');

// TODO: It requires checking each WooCommerce block individually.
/**
 * Dequeue default WooCommerce blocks stylesheets on the front end.
 *
 * Inspect your site's source code '<head>' to find the exact handles of the styles.
 */
function themeslug_dequeue_woocommerce_blocks_styles() {
	// wp_dequeue_style('wc-blocks-style');
}
// add_action('wp_enqueue_scripts', 'themeslug_dequeue_woocommerce_blocks_styles', 100);
