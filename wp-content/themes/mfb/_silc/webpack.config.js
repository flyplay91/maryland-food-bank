const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const extractSass = new ExtractTextPlugin({
    filename: "css/index.css"
});

const copyImages = new CopyWebpackPlugin([
    {
        from: 'src/img',
        to: 'img'
    }
]);

const config = {
		stats: "errors-only",
    entry: "./src/js/index.ts",
    output: {
        filename: "js/index.js",
        path: path.resolve(__dirname, 'build')
    },
    resolve: {
        extensions: ['.js', '.json', '.ts', '.hbs']
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                loader: 'ts-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.scss$/,
                loader: extractSass.extract({
                    use: ['css-loader', 'postcss-loader', 'sass-loader'],
                    fallback: 'style-loader'
                })
            },
            {
                test: /\.(woff|woff2|eot|ttf|svg)$/,
                loader: 'url-loader',
                options: {
                    limit: 1000,
                    name: '[name].[ext]',
                    outputPath: 'fonts/',
                    publicPath: '../'
                },
                exclude: [path.resolve(__dirname, 'src/img')]
            },
            {
                test: /\.(jpg|jpeg|gif|png|svg)$/,
                loader: 'url-loader',
                options: {
                    limit: 1000,
                    name: '[name].[ext]',
                    outputPath: 'img/',
                    publicPath: '../'
                },
                exclude: [path.resolve(__dirname, 'src/fonts')]
            },
            {
                test: /\.(hbs|handlebars)$/,
                loader: 'handlebars-loader'
            },
            {
                test: /\.html$/,
                loader: 'html-loader'
            }
        ]
    },
    plugins: [
        extractSass,
        copyImages
    ]
};

if(process.env.NODE_ENV === 'development') {

    config.devServer = {
        hot: true,
        publicPath: '/build/'
    };

    config.plugins.push(
        new webpack.HotModuleReplacementPlugin()
    );
}

module.exports = config;
