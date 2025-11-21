<?php
/**
 * Register Meta Fields for Block Bindings.
 *
 * @package themeslug
 */

/*
 * Register Custom Meta Fields for Block Bindings
 * This makes the 'written_by' field (managed by ACF)
 * visible to the core Block Bindings UI.
 */
add_action( 'init', 'themeslug_register_meta_fields' );

function themeslug_register_meta_fields() {
	register_meta(
		'post',
		'written_by',
		[
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
			'label'             => __( 'Escrito por', 'themeslug' ),
			'sanitize_callback' => 'wp_strip_all_tags',
		]
	);
}
