// prettier.config.js, .prettierrc.js, prettier.config.mjs, or .prettierrc.mjs

/**
 * @see https://prettier.io/docs/en/configuration.html
 * @type {import("prettier").Config}
 */
const config = {
	quoteProps: "consistent",
	overrides: [
		{
			files: ["*.css"],
			options: {
				printWidth: 120,
			},
		},
		{
			files: ["*.js", "*.jsx"],
			options: {
				singleAttributePerLine: true,
			},
		},
	],
};

export default config;
