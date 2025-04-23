<?php
/**
 * ifiseducacion functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/core-concepts/custom-functionality/
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

// Remove default styles
require_once get_theme_file_path( 'inc/remove-stylesheets.php' );

// Filters
require_once get_theme_file_path( 'inc/add-filters.php' );

// Stylesheets
require_once get_theme_file_path( 'inc/add-stylesheets.php' );

// Block style variations (aka block styles)
require_once get_theme_file_path( 'inc/add-block-style-variations.php' );

// Block stylesheets
require_once get_theme_file_path( 'inc/add-block-stylesheets.php' );

// Blocks
require_once get_theme_file_path( 'inc/add-blocks.php' );

// Custom Post Types and Taxonomies
require_once get_theme_file_path( 'inc/add-cpt-taxonomies.php' );
