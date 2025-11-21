# Set up the production and/or staging WordPress site

## Settings

### Reading

- Under `Your homepage displays`, activate `A static page` and select the `Homepage` (leave `Entries page` unselected).
- Set the maximum number of entries to display to `6`.
- `Ask search engines not to index this site`: activate on the staging site, deactivate on the production site.

### Permalinks

- In `Permalink structure`, select `Post name` and `Save`.

## Plugins

### Required: always

- [Advanced Custom Fields (ACF®)](https://wordpress.org/plugins/advanced-custom-fields/)
- [Antispam Bee](https://wordpress.org/plugins/antispam-bee/)
- [Attributes for Blocks](https://wordpress.org/plugins/attributes-for-blocks/)
- [Gravity Forms](https://www.gravityforms.com/)
  - `Settings` → `Default form theme`: choose `Gravity Forms 2.5`
- [Imagify Image Optimization](https://wordpress.org/plugins/imagify/)
- [Rank Math SEO](https://wordpress.org/plugins/seo-by-rank-math/)
- [SVG Support](https://wordpress.org/plugins/svg-support/)

### Required: only during development

- [All-in-One WP Migration and Backup](https://wordpress.org/plugins/all-in-one-wp-migration/)
  - If possible, use [the Premium/Pro version](https://servmask.com/products/all-in-one-wp-migration-pro)
- [Create Block Theme](https://wordpress.org/plugins/create-block-theme/)
- [CSS Class Manager](https://wordpress.org/plugins/css-class-manager/)
- [WP Migrate (Lite)](https://wordpress.org/plugins/wp-migrate-db/)
  - If possible, it's **highly recommended** to use [the Pro version](https://deliciousbrains.com/wp-migrate-db-pro/)

### Settings of plugins

#### SVG Support

| Option                          | Value           |
| :------------------------------ | :-------------- |
| Restrict SVG Uploads to?        | `Administrator` |
| Do not sanitize for these roles | `Administrator` |
| Sanitize SVG on Front-end       | No              |
| Minify SVG                      | No              |
| Load frontend CSS?              | No              |
| Enable Advanced Mode?           | `✅ Yes`        |
| CSS Class to target             | ` `             |
| Skip Nested SVGs                | No              |
| Output JS in Footer?            | No              |
| USe Vanilla JS?                 | `✅ Yes`        |
| Use Expanded JS?                | No              |
| Force Inline SVG?               | `✅ Yes`        |
| Automatically insert class?     | No              |
| Delete Plugin Data              | No              |
