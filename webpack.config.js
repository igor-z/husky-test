const path = require('path');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {
	mode: 'development',
	entry: path.resolve(__dirname, 'backend/vue/main.js'),
	devtool: 'inline-source-map',
	output: {
		publicPath: "/backend/dist/",
		filename: 'bundle.js',
		path: path.resolve(__dirname, 'backend/web/dist')
	},
	optimization: {
		concatenateModules: true
	},
	module: {
		rules: [
			{
				test: /\.vue$/,
				loader: 'vue-loader'
			},
			{
				test: /\.js$/,
				use: {
					loader: 'babel-loader',
					options: {
						plugins: [
							"@babel/plugin-syntax-dynamic-import"
						]
					}
				}
			},
			{
				test: /\.css$/,
				use: [
					'vue-style-loader',
					'css-loader'
				]
			}
		]
	},
	plugins: [
		new VueLoaderPlugin()
	]
};