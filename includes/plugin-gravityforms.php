<?php
/**
 * Gravity Forms customizations.
 *
 * All actions and filters related to the Gravity Forms plugin.
 *
 * @package themeslug
 */


/**
 * Disable the CSS of the default theme used by forms created with Gravity Forms 2.5 and greater.
 *
 * @since Gravity Forms v2.5
 *
 * @link https://docs.gravityforms.com/gform_disable_form_theme_css/
 *
 * @param bool $disabled Whether to disable the theme CSS.
 */
add_filter( 'gform_disable_form_theme_css', '__return_true' );


/**
 * Create and return a WP_HTML_Processor fragment from HTML string.
 *
 * Helper function to reduce duplication when working with HTML fragments.
 *
 * @param string $html The HTML string to create a fragment from.
 * @param bool   $use_next_tag Whether to use next_tag() instead of next_token(). Default false.
 * @return WP_HTML_Processor|null The processor instance, or null on failure.
 */
function themeslug_create_html_fragment( $html, $use_next_tag = false ) {
	if ( empty( $html ) ) {
		return null;
	}
	
	$fragment = WP_HTML_Processor::create_fragment( $html );
	
	if ( ! $fragment ) {
		return null;
	}
	
	$positioned = $use_next_tag ? $fragment->next_tag() : $fragment->next_token();
	
	if ( $positioned ) {
		return $fragment;
	}
	
	return null;
}


/**
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
function themeslug_gform_input_to_button($button, $form) {
	$fragment = themeslug_create_html_fragment( $button );
	
	if ( ! $fragment ) {
		return $button;
	}

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
add_filter('gform_next_button', 'themeslug_gform_input_to_button', 10, 2);
add_filter('gform_previous_button', 'themeslug_gform_input_to_button', 10, 2);
add_filter('gform_submit_button', 'themeslug_gform_input_to_button', 10, 2);


/**
 * Add custom CSS classes to the submit button.
 *
 * @since WordPress 6.6
 *
 * @link https://docs.gravityforms.com/gform_submit_button/#h-5-append-custom-css-classes-to-the-button
 *
 * @return string
 */
function themeslug_gform_add_custom_css_classes($button, $form) {
	$fragment = themeslug_create_html_fragment( $button );
	
	if ( ! $fragment ) {
		return $button;
	}
	
	$fragment->add_class('button');

	return $fragment->get_updated_html();
}
add_filter( 'gform_submit_button', 'themeslug_gform_add_custom_css_classes', 15, 2 );


/**
 * Adds custom data- attributes to the submit button for specific forms.
 *
 * This function uses a centralized configuration array to apply various
 * data attributes to the submit buttons of specified Gravity Forms.
 *
 * @since WordPress 6.6
 *
 * @param string $button The HTML for the button element.
 * @param array  $form   The current form object.
 * @return string The modified button HTML with data attributes.
 */
function themeslug_gform_add_data_attributes( $button, $form ) {
	// Early return if there's no button HTML to process.
	if ( empty( $button ) ) {
		return $button;
	}

	$form_id = $form['id'];

	/**
	 * Configuration for data attributes.
	 *
	 * Structure:
	 * 'data-attribute-name' => [
	 * 'attribute_value' => [ form_id_1, form_id_2, ... ],
	 * 'another_value'   => [ form_id_3, ... ],
	 * ],
	 */
	$config = [
		'data-appearance' => [
			'inverse' => [  ],
			'outlined' => [  ],
		],
	];

	// Find all attributes that should be applied to the current form.
	$attributes_to_set = [];
	foreach ( $config as $attribute_name => $value_map ) {
		foreach ( $value_map as $attribute_value => $form_ids ) {
			if ( in_array( $form_id, $form_ids, true ) ) {
				$attributes_to_set[ $attribute_name ] = $attribute_value;
				break; // Found the value for this attribute, move to the next one.
			}
		}
	}

	// If no attributes were found for this form, return the button without changes.
	if ( empty( $attributes_to_set ) ) {
		return $button;
	}

	$fragment = themeslug_create_html_fragment( $button, true );

	if ( ! $fragment ) {
		return $button;
	}

	foreach ( $attributes_to_set as $name => $value ) {
		$fragment->set_attribute( $name, $value );
	}

	return $fragment->get_updated_html();
}
add_filter( 'gform_submit_button', 'themeslug_gform_add_data_attributes', 20, 2 );
