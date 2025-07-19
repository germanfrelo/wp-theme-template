<?php
/**
 * Gravity Forms customizations.
 *
 * All actions and filters related to the Gravity Forms plugin.
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
 * @return void
 */
function themeslug_gform_add_custom_css_classes($button, $form) {
	$fragment = WP_HTML_Processor::create_fragment($button);
	$fragment->next_token();
	$fragment->add_class('button');

	return $fragment->get_updated_html();
}
add_filter( 'gform_submit_button', 'themeslug_gform_add_custom_css_classes', 10, 2 );
