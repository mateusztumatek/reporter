const path = require("path");

const webpack = require('webpack')
module.exports = {
  outputDir: path.resolve(__dirname, "../api/public/dist"),
  publicPath: process.env.NODE_ENV == 'production'? '/' : '/dist',
  filenameHashing: false,
  configureWebpack: {

  },
  transpileDependencies: [
    "vuetify"
  ]
}