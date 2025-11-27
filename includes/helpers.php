<?php
/**
 * Theme helper utilities.
 *
 * Small collection of helpers that are used by multiple include files.
 * Keeping these in a single file avoids duplication and makes them
 * easy to reuse across the theme.
 *
 * @package themeslug
 */

if (!function_exists('themeslug_asset_version')) {
	/**
	 * Return an asset version: when the referenced file exists this returns its filemtime
	 * (so the version changes whenever the file is modified). If the file doesn't exist
	 * the function falls back to the theme's version string.
	 *
	 * @param string $relative_path Path relative to theme root.
	 * @return int|string
	 */
	function themeslug_asset_version(string $relative_path) {
		$absolute = get_theme_file_path($relative_path);
		if (file_exists($absolute)) {
			return filemtime($absolute);
		}

		return wp_get_theme()->get('Version');
	}
}

/**
 * Register and enqueue a list of scripts from a base path.
 *
 * Config keys:
 * - files_dir (string): relative base directory, e.g. 'assets/js/editor/' (required)
 * - files (array): list of filenames (no path) to register/enqueue
 * - deps (array): script dependencies
 * - handle_prefix (string|null): optional prefix for handles; defaults to theme stylesheet
 * - in_footer (bool): whether to print scripts in footer (default true)
 * - add_defer (bool): whether to add the `defer` attribute via wp_script_add_data
 * - version_callback (callable|null): optional callback to provide version for each file
 *
 * @param array $config Configuration array.
 * @return array Registered handles.
 */
function themeslug_enqueue_scripts(array $config) {
	// 'files_dir' config is optional. It should be a path relative to the theme root,
	// e.g. 'assets/js/editor/' or 'assets/js'. Normalize it so it always ends with
	// a single trailing slash when present, or is an empty string when omitted.
	// This makes concatenation later predictable: $src = $files_dir . $file;
	$files_dir_base = $config['files_dir'] ?? '';
	// Remove any trailing slashes and add one back if non-empty.
	$files_dir =
		$files_dir_base !== '' ? rtrim($files_dir_base, '/') . '/' : '';
	$files = $config['files'] ?? [];
	$deps = $config['deps'] ?? [];
	$handle_prefix =
		$config['handle_prefix'] ??
		sanitize_key(wp_get_theme()->get_stylesheet());
	$in_footer = $config['in_footer'] ?? true;
	$add_defer = $config['add_defer'] ?? false;

	$registered = [];

	foreach ($files as $file) {
		if (!is_string($file) || '' === $file) {
			continue;
		}

		$name = basename($file, '.js');
		$handle = sanitize_key($handle_prefix . '-' . $name);
		$src = $files_dir . $file;
		$absolute = get_theme_file_path($src);

		// Skip missing files.
		if (!file_exists($absolute)) {
			continue;
		}

		// Use filemtime when available, fallback to theme version.
		$version = themeslug_asset_version($src);

		// Enqueue directly (wp_enqueue_script will register if not already).
		wp_enqueue_script(
			$handle,
			get_theme_file_uri($src),
			$deps,
			$version,
			$in_footer,
		);

		// Add defer/async attributes if requested.
		if ($add_defer) {
			wp_script_add_data($handle, 'defer', true);
		}

		$registered[] = $handle;
	}

	return $registered;
}
