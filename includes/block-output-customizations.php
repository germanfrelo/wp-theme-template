<?php
/**
 * Block Customizations.
 *
 * Config-driven filters that change the output of blocks on the front end.
 *
 * @link https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#front-end
 *
 * @package themeslug
 */

// NOTE: This file implements a small, configuration-driven system for customizing
// specific block outputs. To add a new customization, add an entry to the
// themeslug_get_block_customizations() registry below. See inline docs for options.

/**
 * Registry: define your block customizations here.
 *
 * Each entry is keyed by the block name (e.g. 'core/navigation').
 * Options:
 * - enabled (bool): Turn this customization on/off.
 * - type (string): One of 'replace_button_svg' | 'wrap_select_with_icon'.
 * - when (callable|array): Optional condition. If array, supports ['attrs' => ['key' => value]].
 * - params (array): Type-specific parameters.
 *   - replace_button_svg:
 *       - button_class (string)
 *       - svg: [viewBox (string), width (string), height (string), path_d (string)]
 *   - wrap_select_with_icon:
 *       - wrapper_class (string)
 *       - svg_markup (string)
 *       - select_regex (string) Optional; defaults to '/(<select[^>]*>.*<\/select>)/sU'
 */
function themeslug_get_block_customizations() {
	return [
		'core/navigation' => [
			'enabled' => false, // set true to enable
			'type' => 'replace_button_svg',
			'params' => [
				'button_class' =>
					'wp-block-navigation__responsive-container-open',
				'svg' => [
					'viewBox' => '',
					'width' => '',
					'height' => '',
					'path_d' => '',
				],
			],
		],
		'core/search' => [
			'enabled' => false, // set true to enable
			'type' => 'replace_button_svg',
			'params' => [
				'button_class' => 'wp-block-search__button',
				'svg' => [
					'viewBox' => '',
					'width' => '',
					'height' => '',
					'path_d' => '',
				],
			],
		],
		'core/categories' => [
			'enabled' => false, // set true to enable
			'type' => 'wrap_select_with_icon',
			'when' => [
				'attrs' => ['displayAsDropdown' => true],
			],
			'params' => [
				'wrapper_class' => 'select-wrapper',
				'svg_markup' => '',
				'select_regex' => '/(<select[^>]*>.*<\/select>)/sU',
			],
		],
	];
}

/**
 * Apply the configured transformation for supported blocks.
 *
 * @param string $block_content The block's HTML output.
 * @param array  $block         The parsed block array.
 * @return string Updated HTML.
 */
function themeslug_apply_block_customizations($block_content, $block) {
	if (empty($block_content) || empty($block['blockName'])) {
		return $block_content;
	}

	$registry = themeslug_get_block_customizations();
	$name = $block['blockName'];

	if (!isset($registry[$name])) {
		return $block_content;
	}

	$conf = $registry[$name];
	if (empty($conf['enabled'])) {
		return $block_content;
	}

	// Evaluate optional condition.
	$should_apply = true;
	if (isset($conf['when'])) {
		if (is_callable($conf['when'])) {
			$should_apply = (bool) call_user_func(
				$conf['when'],
				$block,
				$block_content,
			);
		} elseif (is_array($conf['when'])) {
			if (
				isset($conf['when']['attrs']) &&
				is_array($conf['when']['attrs'])
			) {
				foreach ($conf['when']['attrs'] as $attr_key => $attr_val) {
					if (
						!isset($block['attrs'][$attr_key]) ||
						$block['attrs'][$attr_key] !== $attr_val
					) {
						$should_apply = false;
						break;
					}
				}
			}
		}
	}

	if (!$should_apply) {
		return $block_content;
	}

	$type = isset($conf['type']) ? $conf['type'] : '';
	$params =
		isset($conf['params']) && is_array($conf['params'])
			? $conf['params']
			: [];

	switch ($type) {
		case 'replace_button_svg':
			return themeslug_replace_button_svg($block_content, $params);
		case 'wrap_select_with_icon':
			return themeslug_wrap_select_with_icon($block_content, $params);
		default:
			return $block_content;
	}
}
add_filter('render_block', 'themeslug_apply_block_customizations', 10, 2);

/**
 * Helper: Replace the SVG inside a button with a custom icon.
 *
 * Expected params:
 * - button_class (string)
 * - svg (array): viewBox, width, height, path_d
 *
 * @param string $html    Original HTML.
 * @param array  $params  Parameters.
 * @return string Updated HTML.
 */
function themeslug_replace_button_svg($html, $params) {
	if (
		empty($params['button_class']) ||
		empty($params['svg']) ||
		!is_array($params['svg'])
	) {
		return $html;
	}

	$svg = wp_parse_args($params['svg'], [
		'viewBox' => '',
		'width' => '',
		'height' => '',
		'path_d' => '',
	]);

	if ('' === $svg['path_d']) {
		return $html; // nothing to replace
	}

	$tags = new \WP_HTML_Tag_Processor($html);

	if (
		$tags->next_tag([
			'tag_name' => 'button',
			'class_name' => $params['button_class'],
		])
	) {
		if ($tags->next_tag(['tag_name' => 'svg'])) {
			$tags->set_bookmark('svg_start');

			if ($tags->next_tag(['tag_name' => 'path'])) {
				$tags->seek('svg_start');

				if ($svg['viewBox']) {
					$tags->set_attribute('viewBox', $svg['viewBox']);
				}
				if ($svg['width']) {
					$tags->set_attribute('width', $svg['width']);
				}
				if ($svg['height']) {
					$tags->set_attribute('height', $svg['height']);
				}

				$tags->next_tag(['tag_name' => 'path']);
				$tags->set_attribute('d', $svg['path_d']);
			}
		}
	}

	return $tags->get_updated_html();
}

/**
 * Helper: Wrap the first <select> with a wrapper and prepend an SVG.
 *
 * Expected params:
 * - wrapper_class (string)
 * - svg_markup (string)
 * - select_regex (string) Optional
 *
 * @param string $html    Original HTML.
 * @param array  $params  Parameters.
 * @return string Updated HTML.
 */
function themeslug_wrap_select_with_icon($html, $params) {
	$wrapper_class = isset($params['wrapper_class'])
		? $params['wrapper_class']
		: 'select-wrapper';
	$svg_markup = isset($params['svg_markup']) ? $params['svg_markup'] : '';
	$select_regex = isset($params['select_regex'])
		? $params['select_regex']
		: '/(<select[^>]*>.*<\/select>)/sU';

	if (empty($svg_markup)) {
		return $html;
	}

	if (preg_match($select_regex, $html, $matches)) {
		$select_element = $matches[1];
		$wrapped_content =
			'<div class="' .
			esc_attr($wrapper_class) .
			'">' .
			$svg_markup .
			$select_element .
			'</div>';
		$html = str_replace($select_element, $wrapped_content, $html);
	}

	return $html;
}
