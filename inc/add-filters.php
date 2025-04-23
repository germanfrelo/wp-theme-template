<?php
/**
 * Filters.
 */

/**
 * Remove some inline default core styles.
 *
 * @link https://github.com/WordPress/gutenberg/issues/36834#issuecomment-1769802551
 *
 * @param \WP_Theme_JSON_Data $theme_json Class to access and update the underlying data.
 *
 * @return \WP_Theme_JSON_Data
 */
add_filter(
	'wp_theme_json_data_default',
	function ( $theme_json ) {
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
 * Block Navigation:
 * Replace the default 3-line hamburger menu button icon with a custom one.
 *
 * @link https://developer.wordpress.org/reference/classes/wp_html_tag_processor/
 */
function ifiseducacion_customize_nav_menu_toggle_icon($output, $block) {
	// Variables
	$viewBox = '0 0 44 44';
	$width = '44';
	$height = '44';
	$open_path_d = 'M7 32V28.6667H37V32H7ZM7 23.6667V20.3333H37V23.6667H7ZM7 15.3333V12H37V15.3333H7Z';

	$tags = new \WP_HTML_Tag_Processor($output);

	// Find the responsive menu toggle button (open)
	if ($tags->next_tag(array('tag_name' => 'button', 'class_name' => 'wp-block-navigation__responsive-container-open'))) {
		// Find the SVG within the button
		if ($tags->next_tag(array('tag_name' => 'svg'))) {
			// Store the SVG's position
			$tags->set_bookmark('open_svg_start');

			// Check if the SVG contains a path (indicating the 3-line hamburger)
			if ($tags->next_tag(array('tag_name' => 'path'))) {
				// Reset the processor to the SVG start
				$tags->seek('open_svg_start');

				// Modify SVG attributes
				$tags->set_attribute('viewBox', $viewBox);
				$tags->set_attribute('width', $width);
				$tags->set_attribute('height', $height);

				// Move to the path element and modify its 'd' attribute (the icon itself)
				$tags->next_tag(array('tag_name' => 'path'));
				$tags->set_attribute('d', $open_path_d);
			}
		}
	}

	return $tags->get_updated_html();
}
add_filter('render_block_core/navigation', 'ifiseducacion_customize_nav_menu_toggle_icon', 10, 2);

/**
 * Block Search:
 * Replace the default search button icon with a custom one.
 *
 * @link https://developer.wordpress.org/reference/classes/wp_html_tag_processor/
 */
function ifiseducacion_customize_search_button_icon($output, $block) {
	// Variables
	$viewBox = '0 0 18 18';
	$width = '18';
	$height = '18';
	$open_path_d = 'M16.6 18L10.3 11.7C9.8 12.1 9.225 12.4167 8.575 12.65C7.925 12.8833 7.23333 13 6.5 13C4.68333 13 3.14583 12.3708 1.8875 11.1125C0.629167 9.85417 0 8.31667 0 6.5C0 4.68333 0.629167 3.14583 1.8875 1.8875C3.14583 0.629167 4.68333 0 6.5 0C8.31667 0 9.85417 0.629167 11.1125 1.8875C12.3708 3.14583 13 4.68333 13 6.5C13 7.23333 12.8833 7.925 12.65 8.575C12.4167 9.225 12.1 9.8 11.7 10.3L18 16.6L16.6 18ZM6.5 11C7.75 11 8.8125 10.5625 9.6875 9.6875C10.5625 8.8125 11 7.75 11 6.5C11 5.25 10.5625 4.1875 9.6875 3.3125C8.8125 2.4375 7.75 2 6.5 2C5.25 2 4.1875 2.4375 3.3125 3.3125C2.4375 4.1875 2 5.25 2 6.5C2 7.75 2.4375 8.8125 3.3125 9.6875C4.1875 10.5625 5.25 11 6.5 11Z';

	$tags = new \WP_HTML_Tag_Processor($output);

	// Find the search button
	if ($tags->next_tag(array('tag_name' => 'button', 'class_name' => 'wp-block-search__button'))) {
		// Find the SVG within the button
		if ($tags->next_tag(array('tag_name' => 'svg', 'class_name' => 'search-icon'))) {
			// Store the SVG's position
			$tags->set_bookmark('open_svg_start');

			// Check if the SVG contains a path
			if ($tags->next_tag(array('tag_name' => 'path'))) {
				// Reset the processor to the SVG start
				$tags->seek('open_svg_start');

				// Modify SVG attributes
				$tags->set_attribute('viewBox', $viewBox);
				$tags->set_attribute('width', $width);
				$tags->set_attribute('height', $height);

				// Move to the path element and modify its 'd' attribute (the icon itself)
				$tags->next_tag(array('tag_name' => 'path'));
				$tags->set_attribute('d', $open_path_d);
			}
		}
	}

	return $tags->get_updated_html();
}
add_filter('render_block_core/navigation', 'ifiseducacion_customize_search_button_icon', 10, 2);

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
function ifiseducacion_gform_input_to_button($button, $form) {
	$fragment = \WP_HTML_Processor::create_fragment($button);
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
add_filter('gform_next_button', 'ifiseducacion_gform_input_to_button', 10, 2);
add_filter('gform_previous_button', 'ifiseducacion_gform_input_to_button', 10, 2);
add_filter('gform_submit_button', 'ifiseducacion_gform_input_to_button', 10, 2);

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
function ifiseducacion_gform_add_custom_css_classes($button, $form) {
	$fragment = WP_HTML_Processor::create_fragment($button);
	$fragment->next_token();
	$fragment->add_class('button');

	return $fragment->get_updated_html();
}
add_filter( 'gform_submit_button', 'ifiseducacion_gform_add_custom_css_classes', 10, 2 );

/**
 * Plugin Gravity Forms:
 * Disable the default theme used by forms created with Gravity Forms 2.5 and greater.
 *
 * @since Gravity Forms v2.5
 *
 * @link https://docs.gravityforms.com/gform_disable_form_theme_css/
 *
 * @param bool $disabled Whether to disable the theme CSS.
 */
add_filter( 'gform_disable_form_theme_css', '__return_true' );
