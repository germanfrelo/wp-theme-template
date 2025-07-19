export default {
	plugins: {
		"postcss-import-ext-glob": {}, // This plugin must be placed before the "postcss-import" plugin
		"postcss-import": {},
		"postcss-nesting": {},
		"postcss-custom-media": {},
		"postcss-discard-comments": {},
	},
};
