<?php
/**
 * Register custom template part areas.
 *
 * @link https://developer.wordpress.org/themes/templates/template-parts/#registering-custom-areas
 *
 * @package themeslug
 */
function themeslug_template_part_areas(array $areas) {
	$areas[] = [
		"area" => "aside",
		"area_tag" => "aside",
		"label" => __("Aside", "themeslug"),
		"description" => __(
			"Las plantillas de tipo «aside» definen un área de la página cuyo contenido solo está relacionado indirectamente con el contenido principal de la página. Aunque suelen representarse visualmente como barras laterales, su función no es posicional, sino de significado. Suelen utilizarse para mostrar contenido suplementario como publicidad, artículos de blog relacionados, formularios de contacto o de suscripción a una newsletter, secciones de llamada a la acción, etc.",
			"themeslug",
		),
		"icon" => "sidebar",
	];

	return $areas;
}
add_filter("default_wp_template_part_areas", "themeslug_template_part_areas");
