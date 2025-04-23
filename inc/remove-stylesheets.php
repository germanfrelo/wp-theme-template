<?php
/**
 * Dequeue stylesheets.
 */

/**
 * Remove some default core block styles.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_dequeue_style/
 * @link https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/
 *
 * @return void
 */
function ifiseducacion_remove_core_styles() {
	wp_dequeue_style( 'wp-block-button' );
	wp_dequeue_style( 'wp-block-post-template' );
}
add_action( 'wp_enqueue_scripts', 'ifiseducacion_remove_core_styles' );
