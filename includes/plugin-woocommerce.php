<?php

/**
 * WooCommerce customizations.
 */

/**
 * Disable WooCommerce default stylesheets (on the front end).
 *
 * Path of stylesheets: 'wp-content/plugins/woocommerce/assets/css/'
 *
 * This method works for styles specifically added via the 'woocommerce_enqueue_styles' filter.
 *
 * @link https://woocommerce.com/document/disable-the-default-stylesheet/
 * @see 'wp-content/plugins/woocommerce/includes/class-wc-frontend-scripts.php'
 */
function themeslug_disable_wooocommerce_styles($enqueue_styles) {
	unset($enqueue_styles['woocommerce-smallscreen']);
	unset($enqueue_styles['woocommerce-layout']);
	unset($enqueue_styles['woocommerce-blocktheme']);
	unset($enqueue_styles['woocommerce-general']);

	return $enqueue_styles;
}
add_filter('woocommerce_enqueue_styles', 'themeslug_disable_wooocommerce_styles', 1);


// TODO: Investigate carefully. It requires checking each WooCommerce block individually.
/**
 * Disable WooCommerce default block styles (on the front end).
 *
 * Inspect your site's source code '<head>' to find the exact handles of the styles.
 *
 * @link https://themesharbor.com/disabling-css-styles-of-woocommerce-blocks/
 */
function themeslug_disable_woocommerce_block_styles() {
	// wp_dequeue_style('wc-blocks-style');
}
// add_action('wp_enqueue_scripts', 'themeslug_disable_woocommerce_block_styles', 1);


// TODO: Investigate carefully. It requires checking each WooCommerce block individually.
/**
 * Disable WooCommerce default block styles (on the editor).
 *
 * Inspect your site's source code '<head>' to find the exact handles of the styles.
 *
 * @link https://themesharbor.com/disabling-css-styles-of-woocommerce-blocks/
 */
function themeslug_disable_woocommerce_block_editor_styles() {
	// wp_deregister_style('wc-block-editor');
	// wp_deregister_style('wc-blocks-style');
}
// add_action('enqueue_block_assets', 'themeslug_disable_woocommerce_block_editor_styles', 1);
