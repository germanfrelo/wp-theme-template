<?php
/**
 * Register custom template part areas.
 *
 * @link https://developer.wordpress.org/themes/templates/template-parts/#registering-custom-areas
 *
 * @package themeslug
 */

function themeslug_template_part_areas( array $areas ) {
	$areas[] = [
		'area'        => 'aside',
		'area_tag'    => 'aside',
		'label'       => __( 'Aside', 'themeslug' ),
		'description' => __( 'Aside templates define an area of the page whose content is only indirectly related to the main content of the page. Although they are usually represented visually as sidebars, their function is not positional, but rather semantic. They are often used to display supplementary content such as ads, related blog articles, contact or newsletter subscription forms, call-to-action sections, etc.', 'themeslug' ),
		'icon'        => 'sidebar'
	];

	return $areas;
}
add_filter( 'default_wp_template_part_areas', 'themeslug_template_part_areas' );
