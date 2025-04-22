// Reference:
// https://piccalil.li/blog/a-css-project-boilerplate/

import postcss from "postcss";
import postcssJs from "postcss-js";
import plugin from "tailwindcss/plugin";

// Generates Utopia-like CSS clamp values for fluid type and space
import clampGenerator from "./src/css-utils/clamp-generator.js";

// Converts whatever format the project's design tokens are in, into Tailwind friendly configuration objects
import tokensToTailwind from "./src/css-utils/tokens-to-tailwind.js";

// Raw design tokens
import colorTokens from "./src/design-tokens/colors.json" with { type: "json" };
import fontTokens from "./src/design-tokens/fonts.json" with { type: "json" };
import spacingTokens from "./src/design-tokens/spacing.json" with { type: "json" };
import fontLeadingTokens from "./src/design-tokens/text-leading.json" with { type: "json" };
import textSizeTokens from "./src/design-tokens/text-sizes.json" with { type: "json" };
import fontWeightTokens from "./src/design-tokens/text-weights.json" with { type: "json" };
import viewportTokens from "./src/design-tokens/viewports.json" with { type: "json" };

// Process design tokens
const colors = tokensToTailwind(colorTokens.items);
const fontFamily = tokensToTailwind(fontTokens.items);
const fontLeading = tokensToTailwind(fontLeadingTokens.items);
const fontSize = tokensToTailwind(clampGenerator(textSizeTokens.items));
const fontWeight = tokensToTailwind(fontWeightTokens.items);
const spacing = tokensToTailwind(clampGenerator(spacingTokens.items));

/** @type {import('tailwindcss').Config} */
export default {
	content: ["./src/**/*.{html,js,jsx,mdx,njk,twig,vue,json}"],
	// Add color classes to safe list so they are always generated
	safelist: [],
	presets: [],
	theme: {
		screens: {
			sm: `${viewportTokens.min}px`,
			md: `${viewportTokens.mid}px`,
			lg: `${viewportTokens.large}px`,
			xl: `${viewportTokens.max}px`,
		},
		colors,
		spacing,
		fontSize,
		fontLeading,
		fontFamily,
		fontWeight,
		backgroundColor: ({ theme }) => theme("colors"),
		textColor: ({ theme }) => theme("colors"),
		margin: ({ theme }) => ({
			auto: "auto",
			...theme("spacing"),
		}),
		padding: ({ theme }) => theme("spacing"),
	},
	variantOrder: [
		"first",
		"last",
		"odd",
		"even",
		"visited",
		"checked",
		"empty",
		"read-only",
		"group-hover",
		"group-focus",
		"focus-within",
		"hover",
		"focus",
		"focus-visible",
		"active",
		"disabled",
	],

	// Disables Tailwind's reset and usage of RGB/opacity
	corePlugins: {
		preflight: false,
		textOpacity: false,
		backgroundOpacity: false,
		borderOpacity: false,
	},

	// Prevents Tailwind's core components
	blocklist: ["container"],

	// Prevents Tailwind from generating that wall of empty custom properties
	experimental: {
		optimizeUniversalDefaults: true,
	},

	plugins: [
		// Generates custom property values from Tailwind config
		plugin(function ({ addComponents, config }) {
			let result = "";

			const currentConfig = config();

			const groups = [
				{ key: "colors", prefix: "color" },
				{ key: "spacing", prefix: "space" },
				{ key: "fontSize", prefix: "size" },
				{ key: "fontLeading", prefix: "leading" },
				{ key: "fontFamily", prefix: "font" },
				{ key: "fontWeight", prefix: "font" },
			];

			groups.forEach(({ key, prefix }) => {
				const group = currentConfig.theme[key];

				if (!group) {
					return;
				}

				Object.keys(group).forEach((key) => {
					result += `--${prefix}-${key}: ${group[key]};`;
				});
			});

			addComponents({
				":root": postcssJs.objectify(postcss.parse(result)),
			});
		}),

		// Generates custom utility classes
		plugin(function ({ addUtilities, config }) {
			const currentConfig = config();
			const customUtilities = [
				{ key: "spacing", prefix: "flow-space", property: "--flow-space" },
				{ key: "spacing", prefix: "region-space", property: "--region-space" },
				{ key: "spacing", prefix: "gutter", property: "--gutter" },
				{ key: "colors", prefix: "indent-color", property: "--indent-color" },
			];

			customUtilities.forEach(({ key, prefix, property }) => {
				const group = currentConfig.theme[key];

				if (!group) {
					return;
				}

				Object.keys(group).forEach((key) => {
					addUtilities({
						[`.${prefix}-${key}`]: postcssJs.objectify(
							postcss.parse(`${property}: ${group[key]}`),
						),
					});
				});
			});
		}),
	],
};
