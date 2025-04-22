<?php

/**
 * Table of contents:
 * 1. Remove default CSS
 * 2. Add custom CSS/JS/...
 * 3. Custom Post Types (CPT)
 */

/* ======================================================================
1. Remove default CSS
====================================================================== */

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
	'wp_theme_json_data_default',
	function ($theme_json) {
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
 * Remove default core block styles.
 *
 * @link https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/
 */
function ifiseducacion_remove_core_block_styles() {
	wp_dequeue_style('wp-block-button');
	wp_dequeue_style('wp-block-post-template');
}
add_action('wp_enqueue_scripts', 'ifiseducacion_remove_core_block_styles');

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


/* ======================================================================
2. Add custom CSS/JS/...
====================================================================== */

/**
 * Enqueue custom stylesheets on the front end of the website.
 *
 * ❗️ IMPORTANT:
 * The order of these enqueued stylesheets is intentional, ensuring proper specificity and layering of styles.
 * More info: https://piccalil.li/blog/a-css-project-boilerplate/
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#front-end-stylesheets
 *
 * @return void
 */
function ifiseducacion_enqueue_styles() {
	// Active theme's style.css
	wp_enqueue_style(
		'ifiseducacion-style',
		get_stylesheet_uri(),
		array(),
		filemtime(get_parent_theme_file_path('style.css'))
	);

	// Global styles
	wp_enqueue_style(
		'ifiseducacion-dist-css',
		get_parent_theme_file_uri('dist/css/global.css'),
		array(),
		filemtime(get_parent_theme_file_path('dist/css/global.css'))
	);

	// Plugin Gravity Forms styles
	wp_enqueue_style(
		'ifiseducacion-gravity-forms',
		get_parent_theme_file_uri('src/css/wp/wp-plugins/gravity-forms.css'),
		array(),
		filemtime(get_parent_theme_file_path('src/css/wp/wp-plugins/gravity-forms.css'))
	);
}
add_action('wp_enqueue_scripts', 'ifiseducacion_enqueue_styles');

/**
 * Enqueue custom stylesheets in the Editor.
 *
 * ❗️ IMPORTANT:
 * The order of these enqueued stylesheets is intentional, ensuring proper specificity and layering of styles.
 * More info: https://piccalil.li/blog/a-css-project-boilerplate/
 *
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#editor-stylesheets
 *
 * @return void
 */
function ifiseducacion_editor_styles() {
	add_editor_style(array(
		get_stylesheet_uri(), // Active theme's style.css
		get_parent_theme_file_uri('dist/css/global.css'),
		get_parent_theme_file_uri('assets/css/wp-plugins/gravity-forms.css'),

	));
}
add_action('after_setup_theme', 'ifiseducacion_editor_styles');

/**
 * Enqueue a stylesheet for each block (on the front end and in the editor), if it exists in the theme.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_block_style/
 * @link https://developer.wordpress.org/themes/features/block-stylesheets/
 * @link https://markwilkinson.dev/code-snippets/enqueue-stylesheet-for-any-wordpress-block/
 *
 * @return void
 */
function ifiseducacion_block_stylesheets() {
	// Get all of the registered blocks
	$blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

	// If we have block names
	if (!empty($blocks)) {
		// Loop through each block and enqueue its styles
		foreach ($blocks as $block) {
			// Replace slash with hyphen for filename
			$block_slug = str_replace('/', '-', $block->name);

			// Relative path of each block stylesheet
			$block_path = "src/css/wp/wp-blocks/{$block_slug}.css";

			// If we have no file existing for this block, continue
			if (!file_exists(get_theme_file_path($block_path))) {
				continue;
			}

			// Enqueue the block stylesheet
			wp_enqueue_block_style(
				$block->name,
				[
					'handle' => "ifiseducacion-{$block_slug}",
					'src'    => get_theme_file_uri($block_path),
					'path'   => get_theme_file_path($block_path)
				]
			);
		}
	}
}
add_action('init', 'ifiseducacion_block_stylesheets');

/**
 * Register custom block style variations.
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 * @link https://developer.wordpress.org/themes/features/block-style-variations/
 *
 * @return void
 */
function ifiseducacion_block_style_variations() {
	register_block_style(
		array('core/button', 'core/read-more'),
		array(
			'name'         => 'default-inverted',
			'label'        => __('Invertido', 'ifiseducacion')
			// Styles are in the style.css file
		)
	);
	register_block_style(
		array('core/button', 'core/read-more'),
		array(
			'name'         => 'plain-text',
			'label'        => __('Simple', 'ifiseducacion')
			// Styles are in the style.css file
		)
	);
	register_block_style(
		array('core/button', 'core/read-more'),
		array(
			'name'         => 'plain-text-underlined',
			'label'        => __('Simple subrayado', 'ifiseducacion')
			// Styles are in the style.css file
		)
	);
	register_block_style(
		'core/cover',
		array(
			'name'         => 'custom',
			'label'        => __('Custom', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/details',
		array(
			'name'         => 'icon-chevron',
			'label'        => __('Icons Chevron', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/details',
		array(
			'name'         => 'icon-plus-minus',
			'label'        => __('Icons Plus Minus', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'card',
			'label'        => __('Card', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'switcher-2',
			'label'        => __('Columns: from 2 to 1', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'switcher-3',
			'label'        => __('Columns: from 3 to 1', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'switcher-4',
			'label'        => __('Columns: from 4 to 1', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'grid-2',
			'label'        => __('Grid: 2 items', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'grid-3',
			'label'        => __('Grid: 3 items', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/list',
		array(
			'name'         => 'checkmark',
			'label'        => __('Checkmark', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/media-text',
		array(
			'name'         => 'stacked-on-mobile-text-before',
			'label'        => __('Mobile: Text before', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/navigation',
		array(
			'name'         => 'tabs',
			'label'        => __('Tabs', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/navigation-link',
		array(
			'name'         => 'external',
			'label'        => __('External', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/read-more',
		array(
			'name'         => 'outline',
			'label'        => __('Contorno', 'ifiseducacion')
			// Styles are in the style.css file
		)
	);
	register_block_style(
		'core/search',
		array(
			'name'         => 'direction-reversed',
			'label'        => __('Reversed direction', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/separator',
		array(
			'name'         => 'custom',
			'label'        => __('Personalizado', 'ifiseducacion')
			// Styles are in the block's stylesheet file
		)
	);
}
add_action('init', 'ifiseducacion_block_style_variations');

/**
 * Block: Navigation
 *
 * Replace the default 3-line hamburger menu button icon with a custom one.
 *
 * @link https://developer.wordpress.org/reference/classes/wp_html_tag_processor/
 */
function customize_nav_menu_toggle_icon($output, $block) {
	// Variables
	$viewBox = '0 0 44 44';
	$width = '44';
	$height = '44';
	$open_path_d = 'M7 32V28.6667H37V32H7ZM7 23.6667V20.3333H37V23.6667H7ZM7 15.3333V12H37V15.3333H7Z';

	$tags = new WP_HTML_Tag_Processor($output);

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
add_filter('render_block_core/navigation', 'customize_nav_menu_toggle_icon', 10, 2);


/**
 * Block: Search
 *
 * Replace the default search button icon with a custom one.
 *
 * @link https://developer.wordpress.org/reference/classes/wp_html_tag_processor/
 */
function customize_search_button_icon($output, $block) {
	// Variables
	$viewBox = '0 0 18 18';
	$width = '18';
	$height = '18';
	$open_path_d = 'M16.6 18L10.3 11.7C9.8 12.1 9.225 12.4167 8.575 12.65C7.925 12.8833 7.23333 13 6.5 13C4.68333 13 3.14583 12.3708 1.8875 11.1125C0.629167 9.85417 0 8.31667 0 6.5C0 4.68333 0.629167 3.14583 1.8875 1.8875C3.14583 0.629167 4.68333 0 6.5 0C8.31667 0 9.85417 0.629167 11.1125 1.8875C12.3708 3.14583 13 4.68333 13 6.5C13 7.23333 12.8833 7.925 12.65 8.575C12.4167 9.225 12.1 9.8 11.7 10.3L18 16.6L16.6 18ZM6.5 11C7.75 11 8.8125 10.5625 9.6875 9.6875C10.5625 8.8125 11 7.75 11 6.5C11 5.25 10.5625 4.1875 9.6875 3.3125C8.8125 2.4375 7.75 2 6.5 2C5.25 2 4.1875 2.4375 3.3125 3.3125C2.4375 4.1875 2 5.25 2 6.5C2 7.75 2.4375 8.8125 3.3125 9.6875C4.1875 10.5625 5.25 11 6.5 11Z';

	$tags = new WP_HTML_Tag_Processor($output);

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
add_filter('render_block_core/navigation', 'customize_search_button_icon', 10, 2);


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
function ifiseducacion_input_to_button($button, $form) {
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
add_filter('gform_next_button', 'ifiseducacion_input_to_button', 10, 2);
add_filter('gform_previous_button', 'ifiseducacion_input_to_button', 10, 2);
add_filter('gform_submit_button', 'ifiseducacion_input_to_button', 10, 2);

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
function ifiseducacion_add_custom_css_classes($button, $form) {
	$fragment = WP_HTML_Processor::create_fragment($button);
	$fragment->next_token();
	$fragment->add_class('button');

	return $fragment->get_updated_html();
}
add_filter('gform_submit_button', 'ifiseducacion_add_custom_css_classes', 10, 2);

/*
* Product category filter
*/
function ifis_register_blocks() {
	$block_path = get_template_directory() . '/src/blocks/product-filter';

	register_block_type("$block_path/block.json");
}
add_action('init', 'ifis_register_blocks');


/* ======================================================================
3. Custom Post Types (CPT)
====================================================================== */

/**
 * Custom Post Type: Job Offers
 */
add_action('init', function () {
	// Post type
	register_post_type('jobs', [
		'label' => 'Ofertas de empleo',
		'public' => true,
		'has_archive' => true,
		'rewrite' => ['slug' => 'empleos'],
		'supports' => ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'post-formats'],
		'menu_icon' => 'dashicons-portfolio',
		'show_in_rest' => true,
		'labels' => [
			'name' => 'Ofertas de empleo',
			'singular_name' => 'Oferta de empleo',
			'add_new' => 'Añadir nueva',
			'add_new_item' => 'Añadir nueva oferta',
			'edit_item' => 'Editar oferta',
			'new_item' => 'Nueva oferta',
			'view_item' => 'Ver oferta',
			'search_items' => 'Buscar ofertas',
			'not_found' => 'No se encontraron ofertas',
			'not_found_in_trash' => 'No hay ofertas en la papelera',
			'all_items' => 'Todas las ofertas',
		],
		'taxonomies' => ['category_jobs'],
	]);

	// Taxonomy
	register_taxonomy('category_jobs', 'jobs', [
		'label' => 'Categorías de empleo',
		'public' => true,
		'hierarchical' => true,
		'rewrite' => ['slug' => 'categoria-empleo'],
		'show_admin_column' => true,
		'show_in_rest' => true,
	]);
});

/**
 * Register custom taxonomies for WooCommerce products:
 * - tipo_formacion (ej: Online, OnLive, Presencial)
 * - estado_formacion (ej: Nuevos, Últimas plazas)
 *
 * These taxonomies are used to visually label each course on the frontend.
 *
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 *
 * @return void
 */
function ifiseducacion_register_product_taxonomies() {
	// Taxonomy: tipo_formacion (Tipo de formación)
	register_taxonomy(
		'tipo_formacion',
		'product',
		array(
			'label'             => 'Tipo de formación',
			'labels'            => array(
				'name'               => 'Tipos de formación',
				'singular_name'      => 'Tipo de formación',
				'search_items'       => 'Buscar tipos de formación',
				'all_items'          => 'Todos los tipos de formación',
				'edit_item'          => 'Editar tipo de formación',
				'update_item'        => 'Actualizar tipo de formación',
				'add_new_item'       => 'Añadir nuevo tipo de formación',
				'new_item_name'      => 'Nombre del nuevo tipo de formación',
				'menu_name'          => 'Tipo de formación',
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array('slug' => 'tipo-formacion'),
		)
	);

	// Taxonomy: estado_formacion (Estado del curso)
	register_taxonomy(
		'estado_formacion',
		'product',
		array(
			'label'             => 'Estado del curso',
			'labels'            => array(
				'name'               => 'Estados del curso',
				'singular_name'      => 'Estado del curso',
				'search_items'       => 'Buscar estados del curso',
				'all_items'          => 'Todos los estados del curso',
				'edit_item'          => 'Editar estado del curso',
				'update_item'        => 'Actualizar estado del curso',
				'add_new_item'       => 'Añadir nuevo estado del curso',
				'new_item_name'      => 'Nombre del nuevo estado del curso',
				'menu_name'          => 'Estado del curso',
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array('slug' => 'estado-formacion'),
		)
	);
}
add_action('init', 'ifiseducacion_register_product_taxonomies');
