export default {
	plugins: [
		{
			name: "preset-default",
			params: {
				overrides: {
					// Disable a default plugin
					convertPathData: false,
					mergePaths: false,
					removeViewBox: false,

					// Customize the params of a default plugin
					sortAttrs: {
						order: [
							"id",
							"viewBox",
							"width",
							"height",
							"x",
							"x1",
							"x2",
							"y",
							"y1",
							"y2",
							"cx",
							"cy",
							"r",
							"fill",
							"stroke",
							"marker",
							"d",
							"points",
							"class",
							"aria-hidden",
						],
						xmlnsOrder: "front",
					},
				},
			},
		},
	],
};
