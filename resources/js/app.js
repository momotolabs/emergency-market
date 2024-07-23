import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { InertiaProgress } from "@inertiajs/progress";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import DefaultLayout from "@/Client/Layouts/default.vue";
import VueGoogleMaps from "@fawmi/vue-google-maps";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

String.prototype.format = function () {
  const args = arguments[0]
  return this.replace(/\{(.+?)\}/g, function (match, number) {
    return typeof args[`${number}`] !== 'undefined' ? args[`${number}`] : match
  })
}

createInertiaApp({
  resolve: (name) => {
    const page = resolvePageComponent(
      `./Client/Pages/${name}.vue`,
      import.meta.glob("./Client/Pages/**/*.vue")
    );
    page.then((module) => {
      // if (!module.default.layout && !name.startsWith("Login")) {
      // module.default.layout = DefaultLayout;
      // }
    });
    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueGoogleMaps, {
        load: {
          key: "AIzaSyDICbnJgLUFtu3YbluxKyb-9vP9TOIEdeM",
          libraries: "places",
          language: 'en',
          country: ['us'],
          v: 3.52
        },
      })
      .use(ZiggyVue)
      .use(VueSweetalert2)
      .component("Link", Link)
      .component("Head", Head)
      .mount(el);
  },
});

InertiaProgress.init({ showSpinner: true });
