/** @type {import('stylelint').Config} */
export default {
	extends: [
		// The order of configs is important: later configs take precedence over earlier ones
		"stylelint-config-standard", // Extends stylelint-config-recommended and turns on additional rules to enforce modern conventions
		"stylelint-config-recess-order", // Sorts CSS properties
	],
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
			{ severity: "warning" }, // Relax the default 'error' severity level because this rule has limitations
		],
		// Duplicate
		"font-family-no-duplicate-names": [
			true, // Already enabled in stylelint-config-recommended
			{ ignoreFontFamilyNames: ["monospace"] }, // Don't report the 'font-family: monospace, monospace' declaration used in the CSS reset
		],
		// Invalid
		"syntax-string-no-invalid": true,
		// Unknown
		"no-unknown-animations": true,
		"no-unknown-custom-media": true,

		/* Enforce conventions
		(overrides rules from stylelint-config-standard)
		---------------------------------------- */
		// Allowed, disallowed & required
		"property-no-vendor-prefix": [
			true, // Already enabled in stylelint-config-recommended
			{ ignoreProperties: ["/^mask-/"] }, // Allow -webkit-mask-* properties
		],
		// Empty lines
		"comment-empty-line-before": null,
		"declaration-empty-line-before": "never",
		// Max & min
		"max-nesting-depth": [
			4,
			{
				severity: "warning",
				ignore: ["blockless-at-rules", "pseudo-classes"],
			},
		],
		// Pattern
		"custom-property-pattern": null,
		"selector-class-pattern": null,
		"selector-id-pattern": null,
		// Redundant
		"declaration-block-no-redundant-longhand-properties": null,
	},
	ignoreFiles: [
		// See https://stylelint.io/user-guide/configure#ignorefiles
		"node_modules/",
		"**/*.min.*",
		"build/**/*.css",
		"src/styles/global.css",
	],
};
