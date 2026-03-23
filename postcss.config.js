// Asset URL rewriting so relative URLs work inside the editor iframe (<style> tag) and frontend.
// Example: url("../../svg/icon-foo.svg") -> url("/wp-content/themes/<theme>/dist/svg/icon-foo.svg")

import path from "path";
import postcssCustomMedia from "postcss-custom-media";
import postcssDiscardComments from "postcss-discard-comments";
import postcssImport from "postcss-import";
import postcssImportExtGlob from "postcss-import-ext-glob";
import postcssNesting from "postcss-nesting";

// Detect theme folder name from cwd (same as previous behaviour)
const THEME_DIR = path.basename(process.cwd());

// Turn relative asset URLs like ../../svg/file.svg into
// /wp-content/themes/<theme>/dist/svg/file.svg
const REWRITE_CONFIG = {
	// Which extensions to rewrite (add 'png','jpg' if you need raster images)
	exts: ["svg"],
	// Dist root folder and per-ext subfolders
	distRoot: "dist",
	subfolders: {
		svg: "svg",
		// png: "images",
		// jpg: "images",
	},
};

const EXTS_PATTERN = REWRITE_CONFIG.exts
	.map((e) => e.replace(/[-\/\\^$*+?.()|[\]{}]/g, "\\$&"))
	.join("|");

// Match ../../../svg/file.svg or ../../png/img.png etc (depending on exts)
const RELATIVE_ASSET_RE = new RegExp(
	String.raw`(?:\.\.?\/)+(${EXTS_PATTERN})\/([^?#]+\.(${EXTS_PATTERN}))$`,
	"i",
);

function rewriteAssetUrl(url) {
	const m = url.match(RELATIVE_ASSET_RE);
	if (!m) return url;
	const ext = m[1].toLowerCase();
	const file = m[2];
	const sub = REWRITE_CONFIG.subfolders[ext] ?? ext;
	return `/wp-content/themes/${THEME_DIR}/${REWRITE_CONFIG.distRoot}/${sub}/${file}`;
}

export default {
	plugins: [
		// 1. Expand '@import-glob' rules. Must run before 'postcss-import'.
		postcssImportExtGlob(),
		// 2. Bundle all @import files. Keep the default resolver.
		postcssImport(),
		// 3. Handle url() assets by rewriting relative paths to root-relative
		// theme paths (no copying).
		{
			postcssPlugin: "postcss-rewrite-asset-urls",
			Declaration(decl) {
				if (!decl.value.includes("url(")) return;
				// Match both quoted and unquoted url() syntax robustly.
				decl.value = decl.value.replace(
					/url\(\s*(?:"([^"]*)"|'([^']*)'|([^\s)]+))\s*\)/g,
					(match, dq, sq, unquoted) => {
						const url = dq ?? sq ?? unquoted ?? "";
						const rewritten = rewriteAssetUrl(url);
						return rewritten !== url ? `url("${rewritten}")` : match;
					},
				);
			},
		},
		// Option: inline SVGs as data URIs instead — implement a custom plugin
		// with url: 'inline' logic or use a dedicated package if needed.
		// 4. Other PostCSS processing.
		postcssNesting() /* TODO: Uninstall when Baseline is widely available → caniuse.com/css-nesting */,
		postcssCustomMedia(),
		postcssDiscardComments(),
	],
};
