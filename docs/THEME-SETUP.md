# Theme Setup Guide

## Prerequisites

- [**Git**](https://docs.github.com/en/get-started/git-basics)
- [**Node.js and npm**](https://developer.wordpress.org/block-editor/getting-started/devenv/#node-js-development-tools)
- [**Code editor**](https://developer.wordpress.org/block-editor/getting-started/devenv/#code-editor) - Recommended: [VS Code](https://code.visualstudio.com/) with [these extensions](../.vscode/extensions.json)
- [**Local WordPress development environment**](https://developer.wordpress.org/block-editor/getting-started/devenv/#local-wordpress-environment) - WordPress [recommends](https://github.com/WordPress/twentytwentyfive#getting-started) using [wp-env](https://developer.wordpress.org/block-editor/getting-started/devenv/) or [Local](https://localwp.com/)

## Local site setup

Once your local WordPress environment is running:

### 1. Replicate the production/staging site

Use a tool like the [WP Migrate DB (Pro or Lite)](https://deliciousbrains.com/wp-migrate-db-pro/) plugin by WP Engine, or the [All-in-One WP Migration and Backup](https://wordpress.org/plugins/all-in-one-wp-migration/) plugin to easily replicate the live site's content and database locally.

### 2. Improve the local development and debugging experience

To ensure a smooth and efficient workflow, you must enable WordPress's core debugging features and development settings.

Modify the `wp-config.php` file of your local site by replacing **only** the content from `For developers: WordPress debugging mode` to `That's all, stop editing!` with the content in [./wp-config.md](./wp-config.md).

## Theme setup

Complete these steps from your terminal once the local site is ready:

1. **Clone this theme repository** into the `/wp-content/themes/` directory of your local site.
2. **`cd` to the theme directory** using your terminal.
3. **Install the dependencies** with `npm install`.
4. **Find and replace placeholders.** Use your code editor's global search and replace feature to replace all instances of the following placeholders with the project's information:
   - `themeauthor`
   - `themedescription`
   - `themename`
   - `themerepourl`
   - `themeslug`
   - `themeurl`

## Theme architecture and development/deployment workflows

See **[THEME-ARCHITECTURE.md](../docs/THEME-ARCHITECTURE.md)** to understand the theme architecture and the development and deployment workflows.
