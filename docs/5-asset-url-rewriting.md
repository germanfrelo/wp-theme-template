# Asset URL rewriting (SVGs, images)

Why: In the block editor, CSS is often injected into an iframe as <style> tags. Relative URLs like `url(../../svg/icon.svg)` no longer resolve from a physical CSS file path, so icons can disappear in the editor while working fine on the frontend. We fix this at build time by rewriting matching URLs to root‑relative theme paths.

## What it does

During `npm run build:css`, PostCSS rewrites matching relative URLs to a stable root‑relative URL under your active theme:

- Input (in CSS): `url("../../svg/icon-foo.svg")`
- Output (in built CSS): `url("/wp-content/themes/<theme>/dist/svg/icon-foo.svg")`

This works both in the frontend and inside the editor iframe.

## Where to configure

Edit `postcss.config.js`:

```js
const REWRITE_CONFIG = {
  // Which extensions to rewrite (add 'png','jpg' if needed)
  exts: ["svg"],
  // Dist root folder and per-ext subfolders
  distRoot: "dist",
  subfolders: {
    svg: "svg",
    // png: "images",
    // jpg: "images",
  },
};
```

- `exts`: Add file types you want rewritten.
- `distRoot`: Where your built assets output lives (default `dist`).
- `subfolders`: Map extension → subfolder in `dist` (e.g., `svg` → `dist/svg`).

The theme directory name is auto-detected from the current working directory. No env vars needed.

## How to use in CSS

Reference assets relatively from your source CSS. The rewriter recognizes one or more `../` segments before the asset folder:

```css
/* src/css/... */
.button.is-external::after {
  mask-image: url("../../svg/icon-external-link.svg");
}

/* Deeper paths (also supported): */
.details[open] > summary::marker {
  content: "";
  /* e.g., ../../../svg/icon.svg is also fine */
  mask-image: url("../../../svg/icon-details-open.svg");
}
```

At build time, these will become root‑relative URLs pointing at your `dist/<subfolder>/...` locations.

## Adding raster images (optional)

If you need PNG/JPG rewrites too:

1. Update `postcss.config.js`:

```js
const REWRITE_CONFIG = {
  exts: ["svg", "png", "jpg"],
  distRoot: "dist",
  subfolders: {
    svg: "svg",
    png: "images",
    jpg: "images",
  },
};
```

1. Ensure your build copies images into `dist/images` (or whatever folder you choose).

## Troubleshooting

- “My URL didn’t change in the built CSS”: The pattern only rewrites relative URLs that include one or more `../` segments and match one of the configured extensions. Ensure your URL looks like `../svg/...` (or `../../svg/...`, etc.).
- “Editor still can’t find the icon”: Confirm the built file exists in `dist/<subfolder>/<filename>` and that the final CSS points to `/wp-content/themes/<theme>/dist/<subfolder>/<filename>`.
- “Different theme folder name”: The theme folder is auto-detected from the current working directory. If you’re running builds from elsewhere, run them from the theme directory root.
- “I’d rather inline SVGs as data URIs”: You can switch to the alternative `postcss-url` option (commented in `postcss.config.js`) to inline assets instead of rewriting to root‑relative URLs.

## Related scripts

- Build CSS: `npm run build:css`
- Optimize SVGs: `npm run build:svg` (outputs to `dist/svg`)
- Watch CSS: `npm run watch:css`

This keeps editor and frontend behavior consistent without manual path tweaks in CSS.

## Alternative (future): @csstools/postcss-rebase-url

The officially maintained `@csstools/postcss-rebase-url` plugin can rebase relative URLs when bundling CSS. It’s a good option if you prefer the CSSTools ecosystem.

Important difference: it rebases relative to the final CSS file location (e.g., `dist/css/theme.css`). This usually produces paths like `url("../svg/icon.svg")`. These work great in linked stylesheets, but may fail when the block editor inlines CSS into a `<style>` tag (the relative base becomes the document URL, not the CSS file), which is why this theme currently forces root‑relative URLs.

If you switch to `@csstools/postcss-rebase-url`, test that icons still appear inside the editor. If they don’t, consider:

- Keeping the current root‑relative rewrite approach, or
- Using a small custom plugin to convert rebased URLs to root‑relative URLs, or
- Inlining only a very small subset of SVGs as data URIs.

Install:

```bash
npm i -D @csstools/postcss-rebase-url
```

Then add it to `postcss.config.js` and remove/disable the custom rewrite block.
