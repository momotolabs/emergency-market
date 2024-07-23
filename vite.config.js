import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/js/app.js", "resources/css/app.css","resources/css/fonts.css", "resources/css/filament.css"],
      refresh: ["resources/js/**"],

    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  server: { hmr: { host: "localhost" } },
  optimizeDeps: {
    include: ["@fawmi/vue-google-maps", "fast-deep-equal"],
  },
  resolve: {
    alias: {
      "@": "/resources/js",
    },
  },
});
