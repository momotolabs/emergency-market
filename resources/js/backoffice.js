import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { InertiaProgress } from "@inertiajs/progress";
// import ziggy from 'ziggy'
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
// import AppLayout from "@/Client/Layouts/App.vue";
// import dayjs from 'dayjs';

createInertiaApp({
  // resolve: name => require(`./Client/Pages/${name}`),
  resolve: (name) => {
    const page = resolvePageComponent(
      `./Backoffice/Pages/${name}.vue`,
      import.meta.glob("./Backoffice/Pages/**/*.vue")
    );
    // page.then((module) => {
    //   if (!module.default.layout && !name.startsWith("Login")) {
    //     module.default.layout = AppLayout;
    //   }
    // });
    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      // // .use(moment)
      .component("Link", Link)
      .component("Head", Head)
      .mount(el);
  },
});

InertiaProgress.init({ includeCSS: true, showSpinner: true });


