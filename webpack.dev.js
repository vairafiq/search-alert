const common    = require("./webpack.common");
const { merge } = require('webpack-merge');

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const WebpackRTLPlugin     = require("webpack-rtl-plugin");

module.exports = merge(common, {
  mode: "development", // production | development
  plugins: [
    new MiniCssExtractPlugin({
      filename: "../css/[name].css",
    }),
    new WebpackRTLPlugin({
      filename: "../css/[name].rtl.css",
      minify: true,
      sourceMap: true,
    }),
  ],

  optimization: {
    minimize: false,
  }
});