// prettier.config.js, .prettierrc.js, prettier.config.mjs, or .prettierrc.mjs

import wordpressPrettierConfig from "@wordpress/prettier-config";

/**
 * @see https://prettier.io/docs/en/configuration.html
 * @type {import("prettier").Config}
 */
const config = {
	...wordpressPrettierConfig,
	quoteProps: "consistent",
	overrides: [
		{
			files: ["*.html"],
			options: {
				printWidth: 9999,
			},
		},
		{
			files: ["*.css"],
			options: {
				printWidth: 120,
			},
		},
		{
			files: ["*.js", "*.jsx", "*.vue"],
			options: {
				singleAttributePerLine: true,
			},
		},
		{
			files: ["*.jsonc"],
			options: {
				trailingComma: "none",
			},
		},
	],
};

export default config;
