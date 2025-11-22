<?php
/**
 * Login page branding
 *
 * Copy this file into the site's `wp-content/mu-plugins/` directory and
 * place the client's logo alongside it as `login-logo.svg`.
 */

/**
 * Logo image
 */
function mu_plugin_login_page_enqueue_styles() {
	// Enqueue the static stylesheet (place the file next to this PHP file when deploying).
	$style_handle = "mu-plugin-login-page-styles";
	$style_src = plugin_dir_url(__FILE__) . "login-page.css";

	wp_register_style($style_handle, $style_src, [], null);
	wp_enqueue_style($style_handle);
}
add_action("login_enqueue_scripts", "mu_plugin_login_page_enqueue_styles");

/**
 * Login header text
 *
 * Replace the default WordPress link text with the site's name.
 */
function mu_plugin_login_page_header_text() {
	return get_bloginfo("name");
}
add_filter("login_headertext", "mu_plugin_login_page_header_text");

/**
 * Logo link
 *
 * Set the logo link to point to the site's homepage,
 * instead of the default WordPress.org website.
 */
function mu_plugin_login_page_header_url() {
	return home_url();
}
add_filter("login_headerurl", "mu_plugin_login_page_header_url");
