/** @type {import('stylelint').Config} */
export default {
	extends: [
		// The order of configs is important: later configs take precedence over earlier ones
		"stylelint-config-standard", // Extends stylelint-config-recommended and turns on additional rules to enforce modern conventions
		"stylelint-config-recess-order", // Sorts CSS properties
	],
	plugins: ["stylelint-plugin-defensive-css"], // Enforces defensive CSS best practices
	reportDescriptionlessDisables: true,
	reportInvalidScopeDisables: true,
	reportNeedlessDisables: true,
	reportUnscopedDisables: true,
	rules: {
		/* Avoid errors
		---------------------------------------- */
		// Descending
		"no-descending-specificity": [
			true, // Already enabled in stylelint-config-recommended
			{ severity: "warning" }, // Default is 'error', but I prefer 'warning'
		],
		// Duplicate
		"font-family-no-duplicate-names": [
			true, // Already enabled in stylelint-config-recommended
			{ ignoreFontFamilyNames: ["monospace"] }, // Don't report the 'font-family: monospace, monospace' declaration used in the CSS reset
		],
		// Unknown
		"no-unknown-animations": true,
		"no-unknown-custom-media": true,

		/* Enforce conventions
		(overrides rules from stylelint-config-standard)
		---------------------------------------- */
		// Empty lines
		"declaration-empty-line-before": "never",
		// Notation
		"media-feature-range-notation": null, // TODO: Remove when 'baseline' is 'widely available' (~96%) (https://caniuse.com/css-media-range-syntax)
		// Pattern
		"custom-media-pattern": null,
		"custom-property-pattern": null,
		"keyframes-name-pattern": null,
		"selector-class-pattern": null,
		"selector-id-pattern": null,
		// Redundant
		"declaration-block-no-redundant-longhand-properties": null,

		/* Plugin: use-defensive-css
		---------------------------------------- */
		"plugin/use-defensive-css": [
			true,
			{
				"severity": "warning",
				"accidental-hover": false, // Enable as needed
				"background-repeat": false, // base.css already apply 'no-repeat' to all elements
				"custom-property-fallbacks": true,
				"flex-wrapping": true,
				"scroll-chaining": true,
				"scrollbar-gutter": false, // Enable as needed
				"vendor-prefix-grouping": true,
			},
		],
	},
};
