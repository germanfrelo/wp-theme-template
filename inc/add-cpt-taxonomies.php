<?php
/**
 * Register Custom Post Types and Taxonomies.
 */

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
