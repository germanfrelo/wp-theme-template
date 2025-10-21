# Development section in wp-config.php

```php
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 *
 * Also:
 * When you are actively developing with theme.json you may notice it takes 30+ seconds for your changes to show up in the browser, this is because theme.json is cached. To remove this caching issue, set either WP_DEBUG or SCRIPT_DEBUG to 'true' in your wp-config.php. This tells WordPress to skip the cache and always use fresh data.
 *
 * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/global-settings-and-styles/#why-does-it-take-so-long-to-update-the-styles-in-the-browser
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/#wp_debug
 */
if ( ! defined( 'WP_DEBUG' ) ) {
  define( 'WP_DEBUG', true );
}

/**
 * Set the environment type to 'local'.
 */
define( 'WP_ENVIRONMENT_TYPE', 'local' );

/**
 * Set the development mode for the site. Can be 'theme', 'plugin', or 'all'.
 *
 * @link https://make.wordpress.org/core/2023/07/14/configuring-development-mode-in-6-3/
 */
define( 'WP_DEVELOPMENT_MODE', 'all' );

/**
 * Enable Debug logging to the /wp-content/debug.log file.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/#wp_debug_log
 */
define( 'WP_DEBUG_LOG', true );

/**
 * Disable display of errors and warnings.
 * Control whether debug messages (errors and warnings) are shown or not inside the HTML of pages.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/#wp_debug_display
 */
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

/**
 * Use dev versions of core JS and CSS files (only needed if you are modifying these core files).
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/#script_debug
 */
define( 'SCRIPT_DEBUG', true );

/**
 * Enable the use of the Trash for media items.
 *
 * @link https://wordpress.org/plugins/media-trash-button/
 */
define( 'MEDIA_TRASH' , true );

/* That's all, stop editing! Happy publishing. */
```
