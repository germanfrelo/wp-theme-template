<?php

/* =============================================================================================
❗️ IMPORTANT:
Replace all instances of the word 'themeslug' with your actual theme slug. Then remove this message.
============================================================================================= */

/**
 * Theme's functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/core-concepts/custom-functionality/
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */


/**
 * Enqueue custom stylesheets on the front end of the website.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#front-end-stylesheets
 *
 * @return void
 */
function themeslug_enqueue_styles() {
	// Additional stylesheets.
	wp_enqueue_style(
		'themeslug-base',
		get_parent_theme_file_uri('assets/css/base.css'),
		array(),
		wp_get_theme()->get('Version')
	);
	wp_enqueue_style(
		'themeslug-layouts',
		get_parent_theme_file_uri('assets/css/layouts.css'),
		array(),
		wp_get_theme()->get('Version')
	);
	wp_enqueue_style(
		'themeslug-utility-classes',
		get_parent_theme_file_uri('assets/css/utility-classes.css'),
		array(),
		wp_get_theme()->get('Version')
	);
	wp_enqueue_style(
		'themeslug-gravity-forms',
		get_parent_theme_file_uri('assets/css/gravity-forms.css'),
		array(),
		wp_get_theme()->get('Version')
	);

	// Active theme's style.css.
	wp_enqueue_style(
		'themeslug-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get('Version')
	);
}
add_action('wp_enqueue_scripts', 'themeslug_enqueue_styles');


/**
 * Enqueue custom stylesheets in the Editor.
 *
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#editor-stylesheets
 *
 * @return void
 */
function themeslug_editor_styles() {
	add_editor_style(array(
		// Additional stylesheets.
		get_parent_theme_file_uri('assets/css/base.css'),
		get_parent_theme_file_uri('assets/css/layouts.css'),
		get_parent_theme_file_uri('assets/css/utility-classes.css'),
		get_parent_theme_file_uri('assets/css/gravity-forms.css'),
		// Active theme's style.css.
		get_stylesheet_uri()
	));
}
add_action('after_setup_theme', 'themeslug_editor_styles');


/**
 * Enqueue a stylesheet for each block (on the front end and in the editor), if it exists in the theme.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_block_style/
 * @link https://developer.wordpress.org/themes/features/block-stylesheets/
 * @link https://markwilkinson.dev/code-snippets/enqueue-stylesheet-for-any-wordpress-block/
 *
 * @return void
 */
function themeslug_block_stylesheets() {
	// Get all of the registered blocks
	$blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

	// If we have block names
	if (!empty($blocks)) {
		// Loop through each block and enqueue its styles
		foreach ($blocks as $block) {
			// Replace slash with hyphen for filename
			$block_slug = str_replace('/', '-', $block->name);

			// Relative path of each block stylesheet
			$block_path = "assets/css/blocks/{$block_slug}.css";

			// If we have no file existing for this block, continue
			if (!file_exists(get_theme_file_path($block_path))) {
				continue;
			}

			// Enqueue the block stylesheet
			wp_enqueue_block_style(
				$block->name,
				[
					'handle' => "themeslug-{$block_slug}",
					'src'    => get_theme_file_uri($block_path),
					'path'   => get_theme_file_path($block_path)
				]
			);
		}
	}
}
add_action('init', 'themeslug_block_stylesheets');


/**
 * Register custom block style variations.
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 * @link https://developer.wordpress.org/themes/features/block-style-variations/
 *
 * @return void
 */
function themeslug_block_style_variations() {
	register_block_style(
		'core/button', array(
			'name'         => 'brand-1',
			'label'        => __('Brand 1', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/button', array(
			'name'         => 'brand-2',
			'label'        => __('Brand 2', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/button', array(
			'name'         => 'danger',
			'label'        => __('Danger', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/cover', array(
			'name'         => 'custom',
			'label'        => __('Custom', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/details', array(
			'name'         => 'icon-chevron',
			'label'        => __('Icons Chevron', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/details', array(
			'name'         => 'icon-plus-minus',
			'label'        => __('Icons Plus Minus', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group', array(
			'name'         => 'card',
			'label'        => __('Card', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group', array(
			'name'         => 'switcher-2',
			'label'        => __('Columns: from 2 to 1', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group', array(
			'name'         => 'switcher-3',
			'label'        => __('Columns: from 3 to 1', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group', array(
			'name'         => 'switcher-4',
			'label'        => __('Columns: from 4 to 1', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group', array(
			'name'         => 'grid-2',
			'label'        => __('Grid: 2 items', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group', array(
			'name'         => 'grid-3',
			'label'        => __('Grid: 3 items', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/list', array(
			'name'         => 'checkmark',
			'label'        => __('Checkmark', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/media-text', array(
			'name'         => 'stacked-on-mobile-text-before',
			'label'        => __('Mobile: Text before', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/navigation', array(
			'name'         => 'tabs',
			'label'        => __('Tabs', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/navigation-link', array(
			'name'         => 'external',
			'label'        => __('External', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/search', array(
			'name'         => 'direction-reversed',
			'label'        => __('Reversed direction', 'themeslug')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/separator', array(
			'name'         => 'thick',
			'label'        => __('Thick Line', 'themeslug')
			// Styles are in the 'theme.json' file
		)
	);
}
add_action('init', 'themeslug_block_style_variations');


/**
 * Remove some unnecessary inline core styles.
 *
 * @link https://github.com/WordPress/gutenberg/issues/36834#issuecomment-1769802551
 *
 * @param \WP_Theme_JSON_Data $theme_json Class to access and update the underlying data.
 *
 * @return \WP_Theme_JSON_Data
 */
add_filter(
	'wp_theme_json_data_default', function($theme_json) {
		$data = $theme_json->get_data();
		$data['settings']['color']['duotone']['default'] = []; // Remove default color duotone
		$data['settings']['color']['gradients']['default'] = []; // Remove default color gradients
		$data['settings']['color']['palette']['default'] = []; // Remove default color palette
		$data['settings']['spacing']['spacingSizes']['default'] = []; // Remove default spacing sizes
		$data['settings']['typography']['fontSizes']['default'] = []; // Remove default font sizes
		$theme_json->update_with($data); // Updates the theme data
		return $theme_json;
	}
);


/**
 * Plugin Gravity Forms:
 * Filter the next, previous and submit buttons.
 *
 * Replace the form's input buttons with button elements, while maintaining attributes from original input.
 * Reason: "button elements are much easier to style than input elements" (see
 * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/button#notes).
 *
 * @since WordPress 6.6
 *
 * @link https://docs.gravityforms.com/gform_submit_button/#h-1-change-input-to-button
 *
 * @param string $button Contains the input tag to be filtered.
 * @param array  $form   Contains all the properties of the current form.
 * @return string The filtered button.
 */
function themeslug_input_to_button($button, $form) {
	$fragment = WP_HTML_Processor::create_fragment($button);
	$fragment->next_token();

	$attributes = array('id', 'type', 'class', 'onclick');
	$new_attributes = array();
	foreach ($attributes as $attribute) {
		$value = $fragment->get_attribute($attribute);
		if (! empty($value)) {
			$new_attributes[] = sprintf('%s="%s"', $attribute, esc_attr($value));
		}
	}

	return sprintf('<button %s>%s</button>', implode(' ', $new_attributes), esc_html($fragment->get_attribute('value')));
}
add_filter('gform_next_button', 'themeslug_input_to_button', 10, 2);
add_filter('gform_previous_button', 'themeslug_input_to_button', 10, 2);
add_filter('gform_submit_button', 'themeslug_input_to_button', 10, 2);


/**
 * Plugin Gravity Forms:
 * Add custom CSS classes to the submit button.
 *
 * @since WordPress 6.6
 *
 * @link https://docs.gravityforms.com/gform_submit_button/#h-5-append-custom-css-classes-to-the-button
 *
 * @return void
 */
function themeslug_add_custom_css_classes($button, $form) {
	$fragment = WP_HTML_Processor::create_fragment($button);
	$fragment->next_token();
	$fragment->add_class('wp-block-button');
	$fragment->add_class('wp-block-button__link');

	return $fragment->get_updated_html();
}
add_filter('gform_submit_button', 'themeslug_add_custom_css_classes', 10, 2);
