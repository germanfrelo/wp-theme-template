// prettier.config.js, .prettierrc.js, prettier.config.mjs, or .prettierrc.mjs

/**
 * @see https://prettier.io/docs/en/configuration.html
 * @type {import("prettier").Config}
 */
const config = {
	plugins: ["@prettier/plugin-php"],
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
		{
			files: ["*.php"],
			options: {
				parser: "php",
				useTabs: true,
				braceStyle: "1tbs",
			},
		},
	],
};

export default config;
