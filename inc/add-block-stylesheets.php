<?php
/**
 * Enqueue block stylesheets.
 */

/**
 * Enqueue a stylesheet for each block (on the front end and in the editor), if it exists in the theme.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_block_style/
 * @link https://developer.wordpress.org/themes/features/block-stylesheets/
 * @link https://markwilkinson.dev/code-snippets/enqueue-stylesheet-for-any-wordpress-block/
 *
 * @return void
 */
function ifiseducacion_enqueue_block_stylesheets() {
	// Get all of the registered blocks
	$blocks = \WP_Block_Type_Registry::get_instance()->get_all_registered();

	// If we have block names
	if ( !empty( $blocks ) ) {
		// Loop through each block and enqueue its styles
		foreach ( $blocks as $block) {
			// Replace slash with hyphen for filename
			$block_slug = str_replace( '/', '-', $block->name );

			// Relative path of each block stylesheet
			$block_path = "assets/css/wp-blocks/{$block_slug}.css";

			// If we have no file existing for this block, continue
			if ( !file_exists( get_theme_file_path( $block_path ) ) ) {
				continue;
			}

			// Enqueue the block stylesheet
			wp_enqueue_block_style(
				$block->name,
				[
					'handle' => "ifiseducacion-{$block_slug}",
					'src'    => get_theme_file_uri( $block_path),
					'path'   => get_theme_file_path( $block_path)
				]
			);
		}
	}
}
add_action( 'init', 'ifiseducacion_enqueue_block_stylesheets' );
