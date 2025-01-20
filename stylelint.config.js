/** @type {import('stylelint').Config} */
export default {
	extends: [
		// Order matters: later configs take precedence over (override) earlier ones.
		"stylelint-config-standard",
		"stylelint-config-recess-order",
	],
	plugins: ["stylelint-plugin-defensive-css"],
	reportDescriptionlessDisables: true,
	reportInvalidScopeDisables: true,
	reportNeedlessDisables: true,
	reportUnscopedDisables: true,
	rules: {
		/**
		 * ----------------------------------------
		 * Avoid errors
		 * ----------------------------------------
		 */

		// Descending
		"no-descending-specificity": [true, { severity: "warning" }],

		// Duplicate
		"font-family-no-duplicate-names": [
			true,
			{ ignoreFontFamilyNames: ["monospace"] }, // See https://github.com/search?q=repo:germanfrelo/base-css-stylesheet "monospace, monospace"
		],

		// Unknown
		"no-unknown-animations": true,
		"no-unknown-custom-media": true,

		/**
		 * ----------------------------------------
		 * Enforce conventions
		 * ----------------------------------------
		 */

		// Allowed, disallowed & required
		"property-no-vendor-prefix": [
			true,
			{ ignoreProperties: ["text-size-adjust"] }, // Don't report the '-webkit-text-size-adjust' property used in the imported CSS reset
		],
		
		// Empty lines
		"declaration-empty-line-before": "never",
		// Notation
		"media-feature-range-notation": null, // TODO: Remove when browser support is ~96% (https://caniuse.com/css-media-range-syntax)

		// Pattern
		"custom-media-pattern": null,
		"custom-property-pattern": null,
		"keyframes-name-pattern": null,
		"selector-class-pattern": null,
		"selector-id-pattern": null,

		// Redundant
		"declaration-block-no-redundant-longhand-properties": null,

		/**
		 * ----------------------------------------
		 * Plugin: use-defensive-css
		 * ----------------------------------------
		 */

		"plugin/use-defensive-css": [
			true,
			{
				"severity": "warning",
				"accidental-hover": false, // Unncecessary
				"background-repeat": false, // Solved in assets/css/base.css
				"custom-property-fallbacks": false, // TODO: Test it
				"flex-wrapping": true,
				"scroll-chaining": true,
				"scrollbar-gutter": false, // TODO: Check browser support (~78% in Oct. 2024)
				"vendor-prefix-grouping": true,
			},
		],
	},
};
