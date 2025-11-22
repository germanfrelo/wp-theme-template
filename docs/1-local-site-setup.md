# Local site setup guide

This guide will walk you through setting up the WordPress site for local development.

## Prerequisites

- [**Git**](https://docs.github.com/en/get-started/git-basics)
- [**Code editor**](https://developer.wordpress.org/block-editor/getting-started/devenv/#code-editor) (recommended: [VS Code](https://code.visualstudio.com/))
- [**Node.js and npm**](https://developer.wordpress.org/block-editor/getting-started/devenv/#node-js-development-tools)
- [**PHP**](https://www.php.net/downloads.php)
- [**Composer**](https://getcomposer.org/) (also available [via Homebrew](https://formulae.brew.sh/formula/composer))

## Step 1: Install and configure WP Migrate and Local

Both are from WP Engine and are really well integrated.

### WP Migrate

1. Install the [WP Migrate Pro](https://deliciousbrains.com/wp-migrate-db-pro/) plugin **on the production/staging site**.
2. Go to the plugin settings and enable `Pull` and `Push` permissions on the site.

### Local

1. Download, install, and open the [Local](https://localwp.com/) app on you computer.
2. Go to the app settings/preferences and configure some useful settings:
    - **New site defaults**:
      - Environment: `Custom`
      - Admin e-mail: (whatever you want)
      - Domain suffix: `.local`
      - Site path: (whatever you want)
    - **Advanced**:
      - Router mode: choose `Site domains` instead of `localhost` to be able to use the "Copy block styles" feature of WordPress block editor

## Step 2: Replicate the site locally

Follow the WP Migrate guide on how to [import a WordPress Site to Local](https://deliciousbrains.com/wp-migrate-db-pro/doc/importing-wordpress-local-development-environment/).

## Step 3: Configure your local site

Once the site has been imported to Local:

### LocalWP settings for the local site

1. In the Local app, select the project from the list of sites in the sidebar and launch it.
2. `Overview` tab → `SSL`: Click the `Trust` button. Close the program. On macOS, open the `Keychain Access` app, select `System` in the left panel, then select `Certificates` in the right panel. The certificate with the name of the domain you just created will appear there. If a red message appears saying that the certificate is not trusted, open it, click on the Trust drop-down menu, select the `Always Trust` option, close the certificate window, enter your password if prompted, and the message should now appear marked as trusted with a blue + icon. Close the app, reopen the `Local` app, and check that it works (it should say `Trusted`). [More info](https://localwp.com/help-docs/getting-started/ssl-in-local/).
3. `Overview` tab → `One-click admin`: Activate it (toggle → `ON`) and choose the corresponding user.
4. `Tools` tab → `Instant Reload`: Activate it (toggle → `ON`).
5. Open the local site admin, go to `Settings` → `General`, and in the `WordPress Address (URL)` and `Site Address (URL)` fields, replace `http` with `https`.

### Development and debugging settings for the local site

Open the `wp-config.php` file, which is located in `your_local_site_directory/app/public/wp-config.php`, and **only** replace all the lines of code from

`/* For developers: WordPress debugging mode. */`

to

`/* That's all, stop editing! */`

(both included), with the following content:

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
 * When you are actively developing with theme.json you may notice it takes 30+ seconds for your changes to show up in the browser, this is because theme.json is cached. To remove this caching issue, set either WP_DEBUG or SCRIPT_DEBUG to ‘true’ in your wp-config.php. This tells WordPress to skip the cache and always use fresh data.
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
 * Set the development mode for the site to 'all'.
 *
 * Reason: 'all' indicates that this site is used as a WordPress development environment where all three aspects may be modified. For example, this may be relevant when you are working on a specific site as a whole, e.g. for a client.
 *
 * @link https://make.wordpress.org/core/2023/07/14/configuring-development-mode-in-6-3/
 */
define( 'WP_DEVELOPMENT_MODE', 'all' );

/**
 * Enable "Debug logging" to the '/wp-content/debug.log' file.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/#wp_debug_log
 */
define( 'WP_DEBUG_LOG', true );

/**
 * Disable display of errors and warnings on the front end.
 *
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
 * Enable the use of the 'Trash' for media items.
 *
 * @link https://wordpress.org/plugins/media-trash-button/
 */
define( 'MEDIA_TRASH' , true );

/* That's all, stop editing! Happy publishing. */
```
