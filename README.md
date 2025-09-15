# themename

> Get a quick start on building modern WordPress websites with this starter block theme template. It includes a curated and useful set of basic presets.

> [!WARNING]
> This is a personal **work-in-progress** project and is subject to significant changes. If you are going to use it, it is **crucial** that you carefully review and adapt the code to fit your project's requirements.

> [!IMPORTANT]
> There are no current plans to release it on the official WordPress.org themes directory.

## Development

**Table of Contents**:

- [Prerequisites](#prerequisites)
- [Local Site Setup](#local-site-setup)
- [Theme Setup](#theme-setup)
- [CSS](#css)
- [Local Development Workflow](#local-development-workflow)
- [Deployment Workflow](#deployment-workflow)

## Prerequisites

- [**Git**](https://docs.github.com/en/get-started/git-basics)
- [**Node.js and npm**](https://developer.wordpress.org/block-editor/getting-started/devenv/#node-js-development-tools)
- [**Code editor**](https://developer.wordpress.org/block-editor/getting-started/devenv/#code-editor) - Recommended: [VS Code](https://code.visualstudio.com/) with [these extensions](.vscode/extensions.json)
- [**Local WordPress Development Environment**](https://developer.wordpress.org/block-editor/getting-started/devenv/#local-wordpress-environment) - WordPress [recommends](https://github.com/WordPress/twentytwentyfive#getting-started) using [wp-env](https://developer.wordpress.org/block-editor/getting-started/devenv/) or [Local](https://localwp.com/)

## Local Site Setup

Once you have a local WordPress development environment set up and running on your computer, set up the local site.

### 1. Replicate the production/staging site locally

An easy and reliable way is to use the [All-in-One WP Migration and Backup](https://wordpress.org/plugins/all-in-one-wp-migration/) plugin.

### 2. Improve the local development and debugging experience

Modify the `wp-config.php` file of your local site to replace **only** the content from `For developers: WordPress debugging mode` to `That's all, stop editing!` with the following content:

<details>
<summary>Content</summary>

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
 * Set the development mode for the site to 'theme'.
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

</details>

## Theme Setup

Once your local site is set up:

1. **Clone this theme repository** into the `/wp-content/themes/` directory of your local site.
2. **`cd` to the theme directory** using your terminal.
3. **Find and replace placeholders.** Use the global search and replace feature in your code editor to replace all instances of the following placeholders with your own project's information:
   - `themeauthor`
   - `themedescription`
   - `themename`
   - `themerepourl`
   - `themeslug`
   - `themeurl`
4. **Install the dependencies** with `npm install`.

## CSS

> [!IMPORTANT]
> This theme uses a modular CSS architecture based on the **[CUBE CSS methodology](https://piccalil.li/blog/cube-css/)** and **[this CSS project boilerplate](https://piccalil.li/blog/a-css-project-boilerplate/)**, adapted to the constraints of a WordPress block theme and block/site editor.

These are the theme's main CSS-related directories and files:

```text
/
├── inc/
│   ├── block-style-variations.php
│   └── styles.php
├── src/
│   └── styles/
│       ├── blocks/
│       ├── compositions/
│       ├── global/
│       ├── regions/
│       ├── utilities/
│       └── global.css
├── postcss.config.js
├── style.css
└── theme.json
```

### `theme.json`

This file is primarily used to:

- Define and configure **some settings and global/primitive design tokens**. Except those defined as "custom", the rest will be available in the editor.
- Register **custom templates**, **template parts**, and **patterns**.

> [!IMPORTANT]
> **It's _not_ used for applying styles.**

### `style.css`

WordPress requires this file solely for theme registration metadata, such as the theme's name, author and version.

> [!IMPORTANT]
> This file is for metadata only. **It's _not_ enqueued by the theme. Do _not_ use it for adding any CSS.**

### Theme's main styles

The theme's main styles are in **`src/styles/`**, split into multiple files and organized in directories:

```text
src/styles/
├── blocks/
│   ├── button.css
│   ├── ...
│   ├── wp-block-{block_slug}.css
│   ├── ...
│   ├── {plugin_slug}-{block_slug}.css
│   └── ...
├── compositions/
│   ├── cluster.css
│   ├── flow.css
│   ├── frame.css
│   ├── grid.css
│   ├── icon.css
│   ├── reel.css
│   ├── repel.css
│   ├── sidebar.css
│   ├── stack.css
│   ├── switcher.css
│   └── wrapper.css
├── global/
│   ├── custom-media-queries.css
│   ├── global-styles.css
│   ├── reset.css
│   ├── variables-component-tokens.css
│   └── variables-system-tokens.css
├── regions/
│   ├── ...
│   ├── site-footer.css
│   ├── site-header.css
│   └── ...
├── utilities/
│   ├── ...
│   ├── region.css
│   ├── text-align.css
│   ├── text-wrap.css
│   ├── visually-hidden.css
│   └── ...
└── global.css
```

The structure is based on the [CUBE CSS methodology](https://piccalil.li/blog/cube-css/) and [boilerplate](https://piccalil.li/blog/a-css-project-boilerplate/) previously mentioned.

The primary entry point is the **`global.css`** file. It uses `@import` rules (processed by PostCSS) to pull in all stylesheets that are organized in directories.

> [!IMPORTANT]
> **The specific import order is critical for correct CSS specificity.**

> [!NOTE]
> Only stylesheets in `global/` are imported explicitly and in a specific order. Stylesheets in the other directories are all imported in default (alphabetical) order, thanks to the `import-glob` PostCSS plugin. This means that **any new `.css` file created in these directories is automatically imported**.

Some CSS files probably don't need to be changed, whereas other do:

| File/Directory                          | Needs Changes?                                                                       |
| :-------------------------------------- | :----------------------------------------------------------------------------------- |
| `global/custom-media-queries.css`       | Probably.                                                                            |
| `global/global-styles.css`              | Yes.                                                                                 |
| `global/reset.css`                      | Unlikely. It contains useful project-agnostic reset styles.                          |
| `global/variables-component-tokens.css` | Yes.                                                                                 |
| `global/variables-system-tokens.css`    | Yes.                                                                                 |
| `compositions/`                         | Unlikely. It contains a bunch of predefined, project-agnostic compositional layouts. |
| `blocks/`                               | Yes.                                                                                 |
| `regions/`                              | Yes.                                                                                 |
| `utilities/`                            | Probably.                                                                            |

### Automated compilation

PostCSS processes the file **`src/styles/global.css`**. It resolves all imports and combines all the different CSS files into a single, optimized file: **`build/styles/global.css`**.

This process happens automatically:

- During the [**local development workflow**](#local-development-workflow) when you run `npm start`.
- As part of the [**deployment workflow**](#deployment-workflow) when you push commits or merge PRs to the repository's default branch.

This means you **never need to compile CSS manually** (i.e., run `npm run build`).

### Enqueuing

> [!IMPORTANT]
> **The theme enqueues both `style.css` and `build/styles/global.css` CSS files.**
> They are enqueued by `inc/styles.php`, **on the website and in the site editor**.

## Local Development Workflow

Once you have followed the [Local Site Setup](#local-site-setup) and the [Theme Setup](#theme-setup), you can now start developing.

Open your terminal in the theme directory and run:

```sh
npm run start
```

This command builds the development version of the theme's assets:

- Styles: from `src/styles/` to `build/styles/`

It then activates a "watch" mode, automatically recompiling and rebuilding necessary files in real-time as you make and save changes to your code.

> [!IMPORTANT]
> While `npm run start` automatically rebuilds assets, whether these changes appear in your local WordPress site depends on your development environment. Tools like Local with its "[Instant Reload](https://localwp.com/help-docs/local-features/instant-reload/)" feature provide immediate CSS updates. For JavaScript changes in blocks, a browser refresh might still be necessary in some setups.

### Code Quality: Formatting and Linting

Before committing your changes, please ensure your code adheres to the project's standards.

- **Format your code:** Run `npm run format`.
- **Check for linting errors:** Run `npm run lint`.

These formatting and linting checks are also automatically run on staged files before each commit.

It's also recommended to install the extensions of these tools for your code editor, such as [the ones for VS Code](.vscode/extensions.json).

## Deployment Workflow

This theme uses [a CI/CD pipeline](https://en.wikipedia.org/wiki/CI/CD) via GitHub Actions to automate the build and deployment process to the production/staging server. The file is `.github/workflows/deploy.yml`.

Upon pushing changes or merging Pull Requests to the repository's default branch, the pipeline will:

1. Set up the Node.js environment.
2. Install theme dependencies.
3. Build production-ready assets such as the theme's main CSS.
4. Deploy the built theme files to the configured server.
