# Theme Architecture and Development/Deployment Workflows

**Table of Contents**:

- [CSS architecture](#css-architecture)
- [Local development workflow](#local-development-workflow)
- [Deployment workflow](#deployment-workflow)

## CSS architecture

> [!IMPORTANT]
> This theme uses a **modular CSS architecture** based on the [**CUBE CSS methodology**](https://piccalil.li/blog/cube-css/) and **[this CSS project boilerplate](https://piccalil.li/blog/a-css-project-boilerplate/)**. It requires an automated build process.

### The "Why" behind the build

Maintainable CSS and production performance are prioritized over relying on the cumbersome CSS-in-JSON provided by [Full Site Editing (FSE)](https://fullsiteediting.com/). This requires a **PostCSS build system** (Node.js/npm) because:

| Rationale                                          | Necessity for this theme                                                                                                                                                                                                                                                                          | PostCSS plugin support                                                                                                                                            |
| :------------------------------------------------- | :------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | :---------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Enhanced developer experience (DX) & debugging** | Centralizing styles in modular `/src` files allows developers to use powerful **code editor features** (autocompletion, syntax checking) unavailable in `theme.json`. Additionally, using `theme.css` avoids naming conflicts with the WordPress core-injected `style.css` for clearer debugging. | **`postcss-nesting`**, **`postcss-custom-media`** (Enables modern CSS features for better readability and maintainability).                                       |
| **Enhanced performance**                           | The theme is designed to load only **one optimized CSS file** (`build/css/theme.css`), with all the comments removed, which significantly reduces HTTP requests, file size, and improves loading speed.                                                                                           | **`postcss-import`** (Combines all source files into the single output file). **`postcss-discard-comments`** (Strips all developer comments to reduce file size). |

### Theme CSS files and folders

These are the theme's main CSS-related directories and files:

```text
/
├── includes/
│   ├── block-style-variations.php
│   ├── ...
│   └── styles.php
├── src/
│   └── css/
│       ├── blocks/
│       │   ├── {reusable_block}.css
│       │   ├── ...
│       │   ├── wp-block-{block_slug}.css
│       │   ├── ...
│       │   ├── {plugin_slug}-{block_slug}.css
│       │   └── ...
│       ├── compositions/
│       │   ├── {layout_1}.css
│       │   ├── {layout_2}.css
│       │   └── ...
│       ├── global/
│       │   ├── custom-media-queries.css
│       │   ├── global-styles.css
│       │   ├── reset.css
│       │   ├── variables-primitive.css
│       │   └── variables-semantic.css
│       ├── regions/
│       │   ├── ...
│       │   ├── site-footer.css
│       │   ├── site-header.css
│       │   └── ...
│       │   └── ...
│       ├── utilities/
│       │   ├── {utility_class_1}.css
│       │   ├── {utility_class_2}.css
│       │   └── ...
│       └── theme.css
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

The structure is based on the [CUBE CSS methodology](https://piccalil.li/blog/cube-css/) and [boilerplate](https://piccalil.li/blog/a-css-project-boilerplate/) previously mentioned.

The primary entry point is the **`theme.css`** file. It uses `@import` rules (processed by PostCSS) to pull in all stylesheets that are organized in directories.

> [!IMPORTANT]
> **The specific import order is critical for correct CSS specificity.**

> [!NOTE]
> Only stylesheets in `global/` are imported explicitly and in a specific order. Stylesheets in the other directories are all imported in default (alphabetical) order, thanks to the `import-glob` PostCSS plugin. This means that **any new `.css` file created in these directories is automatically imported**.

Some CSS files probably don't need to be changed, whereas other do:

| File/Directory                                                       | Needs Changes?                                                                       |
| :------------------------------------------------------------------- | :----------------------------------------------------------------------------------- |
| `global/global-styles.css`                                           | Yes.                                                                                 |
| `global/reset.css`                                                   | No. It contains useful project-agnostic reset styles.                                |
| `global/variables-primitive.css` and `global/variables-semantic.css` | Yes.                                                                                 |
| `compositions/`                                                      | Unlikely. It contains a bunch of predefined, project-agnostic compositional layouts. |
| `blocks/`                                                            | Yes.                                                                                 |
| `regions/`                                                           | Yes.                                                                                 |
| `utilities/`                                                         | Probably.                                                                            |

## Local development workflow

The project includes `npm` scripts to automate the build, development, and code quality process.

### Primary commands

| Command         | Description                                                                                                                                          |
| :-------------- | :--------------------------------------------------------------------------------------------------------------------------------------------------- |
| `npm start`     | **For development.** Builds your CSS once, then starts a **watcher** to automatically recompile and rebuild assets in real-time as you make changes. |
| `npm run build` | **For production.** Performs a full, clean build of all theme assets, ready for deployment.                                                          |

> [!TIP]
> **Automatic asset rebuild:** Once `npm start` is running, you **never need to manually compile CSS** (i.e., run `npm run build`).

> [!IMPORTANT]
> **Asset reloading:** While `npm start` automatically rebuilds assets, whether these changes appear immediately on your local site depends on your environment. Tools like Local with its **"[Instant Reload](https://localwp.com/help-docs/local-features/instant-reload/)"** feature provide immediate **CSS updates**. For JavaScript changes in blocks, a browser refresh might still be necessary in some setups.

### Code quality: formatting and linting

Code quality checks run automatically on staged files before each commit. You can also run them manually:

- **`npm run format`**: Formats all code.
- **`npm run lint`**: Lints all CSS (and other) files.

It's also recommended to install the extensions for these tools in your code editor (e.g., [VS Code extensions](../.vscode/extensions.json)).

## Deployment workflow

The theme is deployed automatically using a **CI/CD pipeline** via GitHub Actions, as defined in `.github/workflows/deploy.yml`.

The pipeline is triggered on any push to the branch defined in `deploy.yml` (usually `main` or `dev`) and targets the **staging server**.

The deployment uses an explicit **`.rsyncignore`** file to exclude all unnecessary development files, ensuring only the minimal, optimized set of production files is deployed.
