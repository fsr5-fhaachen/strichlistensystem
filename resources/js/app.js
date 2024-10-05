import { createApp, h } from 'vue';

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { library } from '@fortawesome/fontawesome-svg-core';
import { 
  faArrowLeft,
  faBeer,
  faBolt,
  faChartLine,
  faCode,
  faFaucet,
  faLemon,
  faPaintBrush,
  faQrcode,
  faRobot,
  faSignOutAlt,
  faStar,
  faUsers,
  faWineBottle,
  faBriefcase,
 } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import axios from 'axios';
import VueAxios from 'vue-axios';
//import { InertiaProgress } from '@inertiajs/progress'
import { Inertia } from '@inertiajs/inertia';
import NProgress from 'nprogress';

// fontawesome
library.add(
  faArrowLeft,
  faBeer,
  faBolt,
  faChartLine,
  faCode,
  faFaucet,
  faLemon,
  faPaintBrush,
  faQrcode,
  faRobot,
  faSignOutAlt,
  faStar,
  faUsers,
  faWineBottle,
  faBriefcase,
);

Inertia.on('start', () => NProgress.start());
Inertia.on('finish', () => NProgress.done());

createInertiaApp({
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueAxios, axios)
      .component('font-awesome-icon', FontAwesomeIcon)
      .component(VueQrcode.name, VueQrcode);
    app.provide('axios', app.config.globalProperties.axios);

    return app.mount(el);
  },
})

