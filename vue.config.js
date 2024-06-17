const path = require("path");

module.exports = {
  publicPath: "/",
  outputDir: "dist",
  assetsDir: "",
  productionSourceMap: false,

  configureWebpack: {
    resolve: {
      alias: {
        "@": path.resolve(__dirname, "src"),
      },
    },
  },

  devServer: {
    historyApiFallback: true,
  },

  // This is required to properly handle SPA routing on Vercel
  pluginOptions: {
    quasar: {
      importStrategy: "kebab",
      rtlSupport: false,
    },
  },

  transpileDependencies: ["quasar"],

  chainWebpack: (config) => {
    config.plugin("html").tap((args) => {
      args[0].template = path.resolve(__dirname, "public/index.html");
      return args;
    });
  },
};
