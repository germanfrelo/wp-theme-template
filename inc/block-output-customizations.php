<?php

/**
 * Block Customizations.
 *
 * Filters that modify the output or behavior of specific core blocks.
 */


/**
 * Block Categories:
 * Customize the Categories block dropdown to include an SVG icon within a wrapper.
 *
 * @param string $block_content The block's HTML output.
 * @param array  $block         The block object.
 * @return string The modified HTML output.
 */
function themeslug_customize_categories_dropdown( $block_content, $block ) {
	$block_name = 'core/categories';
	$display_as_dropdown_attr = 'displayAsDropdown';
	$wrapper_class = 'select-wrapper';
	$select_regex = '/(<select[^>]*>.*<\/select>)/sU';
	$svg_markup = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" fill="currentcolor" aria-hidden="true"><path d="M21.24 3.285H7.288a.565.565 0 0 1-.555-.554c0-.299.256-.555.555-.555H21.24c.299 0 .555.256.555.555a.565.565 0 0 1-.555.554ZM2.936 3.285H.76a.565.565 0 0 1-.555-.554c0-.299.256-.555.555-.555h2.176c.299 0 .555.256.555.555a.538.538 0 0 1-.555.554ZM21.24 8.533h-3.67a.565.565 0 0 1-.554-.554c0-.3.256-.555.555-.555h3.669c.299 0 .555.256.555.554a.565.565 0 0 1-.555.555ZM13.219 8.533H.759a.565.565 0 0 1-.554-.554c0-.3.256-.555.555-.555h12.459c.298 0 .554.256.554.554a.565.565 0 0 1-.554.555ZM21.24 13.824H7.288a.565.565 0 0 1-.555-.555c0-.298.256-.554.555-.554H21.24c.299 0 .555.256.555.554a.565.565 0 0 1-.555.555ZM2.936 13.824H.76a.565.565 0 0 1-.555-.555c0-.341.256-.597.555-.597h2.176c.299 0 .555.256.555.554.042.342-.214.598-.555.598Z" /><path d="M5.112 5.461a2.75 2.75 0 0 1-2.73-2.73A2.75 2.75 0 0 1 5.111 0a2.75 2.75 0 0 1 2.73 2.73 2.722 2.722 0 0 1-2.73 2.731Zm0-4.352a1.62 1.62 0 1 0-.001 3.242 1.62 1.62 0 0 0 .001-3.242ZM15.395 10.71a2.75 2.75 0 0 1-2.731-2.731 2.75 2.75 0 0 1 2.73-2.731 2.75 2.75 0 0 1 2.731 2.73 2.722 2.722 0 0 1-2.73 2.731Zm0-4.353a1.62 1.62 0 1 0-.002 3.242 1.62 1.62 0 0 0 .002-3.242ZM5.112 16a2.75 2.75 0 0 1-2.73-2.73 2.722 2.722 0 0 1 2.73-2.731 2.75 2.75 0 0 1 2.73 2.73C7.886 14.763 6.649 16 5.113 16Zm0-4.352a1.62 1.62 0 1 0-.001 3.241 1.62 1.62 0 0 0 .001-3.241Z" /></svg>';

	// Check if the current block is the target Categories block and is set to display as a dropdown.
	if ( $block['blockName'] === $block_name && isset( $block['attrs'][ $display_as_dropdown_attr ] ) && $block['attrs'][ $display_as_dropdown_attr ] ) {
		// Use a regular expression to find the <select> element within the block content.
		if ( preg_match( $select_regex, $block_content, $matches ) ) {
			// The entire matched <select> element (including tags and content).
			$select_element = $matches[1];
			// Create the HTML for the wrapping div, including the SVG and the <select> element.
			$wrapped_content = '<div class="' . esc_attr( $wrapper_class ) . '">' . $svg_markup . $select_element . '</div>';
			// Replace the original <select> element in the block content with the new wrapped content.
			$block_content = str_replace( $select_element, $wrapped_content, $block_content );
		}
	}
	// Return the (potentially) modified block content.
	return $block_content;
}
add_filter( 'render_block_core/categories', 'themeslug_customize_categories_dropdown', 10, 2 );
