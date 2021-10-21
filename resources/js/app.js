import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { library } from '@fortawesome/fontawesome-svg-core'
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
  faStar,
  faUsers,
  faWineBottle,
 } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

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
  faStar,
  faUsers,
  faWineBottle,
)

//import { InertiaProgress } from '@inertiajs/progress'

//InertiaProgress.init()

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component('font-awesome-icon', FontAwesomeIcon)
      .mount(el)
  },
})