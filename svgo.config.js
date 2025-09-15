export default {
	js2svg: {
		pretty: true,
		eol: "lf",
		indent: "\t",
	},
	plugins: [
		{
			name: "preset-default",
			params: {
				overrides: {
					convertPathData: false,
					mergePaths: false,
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
