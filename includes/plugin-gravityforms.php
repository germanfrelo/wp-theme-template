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
 * @return WP_HTML_Processor|null The processor instance, or null on failure.
 */
function themeslug_create_html_fragment( $html ) {
	if ( empty( $html ) ) {
		return null;
	}

	$fragment = WP_HTML_Processor::create_fragment( $html );

	if ( $fragment && $fragment->next_token() ) {
		return $fragment;
	}

	return null;
}


/**
 * Filter the next, previous and submit buttons.
 *
 * Replace the form's input buttons with button elements, while maintaining all attributes from the original input for better compatibility.
 * Reason for the change: "button elements are much easier to style than input elements" (see
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
function themeslug_gform_input_to_button( $button, $form ) {
	$fragment = \WP_HTML_Processor::create_fragment( $button );
	if ( ! $fragment->next_tag( 'input' ) ) {
		return $button; // Not a valid input, return original.
	}

	// Get the text for the button from the input's 'value' attribute.
	$button_text = $fragment->get_attribute( 'value' );

	// Start building the new button tag.
	$new_button_html = '<button';

	// Loop over ALL attributes from the original input using the correct method.
	foreach ( $fragment->get_attribute_names_with_prefix( '' ) as $attribute_name ) {
		// Skip 'value', as it becomes the button's text content.
		// Attribute names from the processor are already lowercase.
		if ( 'value' === $attribute_name ) {
			continue;
		}

		// Get the attribute value.
		$value = $fragment->get_attribute( $attribute_name );

		// Re-add the attribute to our new button string.
		// This correctly handles boolean attributes (like 'disabled').
		if ( true === $value ) {
			$new_button_html .= ' ' . esc_attr( $attribute_name );
		} else {
			$new_button_html .= sprintf( ' %s="%s"', esc_attr( $attribute_name ), esc_attr( $value ) );
		}
	}

	// Ensure the button has type="submit" if the original was a submit
	// (This might be redundant if 'type' is copied, but it's a good safeguard).
	if ( 'submit' === strtolower( $fragment->get_attribute( 'type' ) ) && false === strpos( $new_button_html, 'type=' ) ) {
		$new_button_html .= ' type="submit"';
	}

	// Close the tag and add the text inside a 'span' element.
	$new_button_html .= '><span>' . esc_html( $button_text ) . '</span></button>';

	return $new_button_html;
}
add_filter( 'gform_next_button', 'themeslug_gform_input_to_button', 10, 2 );
add_filter( 'gform_previous_button', 'themeslug_gform_input_to_button', 10, 2 );
add_filter( 'gform_submit_button', 'themeslug_gform_input_to_button', 10, 2 );


/**
 * Add custom CSS classes to the submit button.
 *
 * @since WordPress 6.6
 *
 * @link https://docs.gravityforms.com/gform_submit_button/#h-5-append-custom-css-classes-to-the-button
 *
 * @return string
 */
function themeslug_gform_add_custom_css_classes( $button, $form ) {
	$fragment = WP_HTML_Processor::create_fragment( $button );
	$fragment->next_token();
	$fragment->add_class( 'button' );

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
		'data-___' => [
			'___' => [],
			'___' => [],
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

	$fragment = themeslug_create_html_fragment( $button );

	if ( ! $fragment ) {
		return $button;
	}

	foreach ( $attributes_to_set as $name => $value ) {
		$fragment->set_attribute( $name, $value );
	}

	return $fragment->get_updated_html();
}
add_filter( 'gform_submit_button', 'themeslug_gform_add_data_attributes', 20, 2 );
