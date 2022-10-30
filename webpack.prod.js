const common    = require("./webpack.common");
const { merge } = require('webpack-merge');

const MiniCssExtractPlugin   = require("mini-css-extract-plugin");
const WebpackRTLPlugin       = require("webpack-rtl-plugin");
const FileManagerPlugin      = require('filemanager-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = merge(common, {
  mode: "production", // production | development
  watch: false,
  plugins: [
    new MiniCssExtractPlugin({
      filename: "../css/[name].min.css",
    }),
    new WebpackRTLPlugin({
      filename: "../css/[name].rtl.min.css",
      minify: true,
    }),
    new CleanWebpackPlugin({
      dry: false,
      cleanOnceBeforeBuildPatterns: [ '../css/*.map', '../js/*.map' ],
      dangerouslyAllowCleanPatternsOutsideProject: true,
    }),
    new FileManagerPlugin({
      events: {
        onEnd: [
          {
            copy: [
              { source: './app', destination: './__build/search-alert/search-alert/app' },
              { source: './assets', destination: './__build/search-alert/search-alert/assets' },
              { source: './helper', destination: './__build/search-alert/search-alert/helper' },
              { source: './languages', destination: './__build/search-alert/search-alert/languages' },
              { source: './vendor', destination: './__build/search-alert/search-alert/vendor' },
              { source: './view', destination: './__build/search-alert/search-alert/view' },
              { source: './*.php', destination: './__build/search-alert/search-alert' },
              { source: './*.txt', destination: './__build/search-alert/search-alert' },
            ],
          },
          {
            archive: [
              { source: './__build/search-alert', destination: './__build/search-alert.zip' },
            ],
          },
          {
            delete: ['./__build/search-alert'],
          },
        ],
      },
    }),
  ],
  optimization: {
    minimize: true,
  },
  output: {
    filename: "../js/[name].min.js",
  },
});