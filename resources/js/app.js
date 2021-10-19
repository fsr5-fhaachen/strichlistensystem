import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { library } from '@fortawesome/fontawesome-svg-core'
import { 
  faBolt,
  faChartLine,
  faCode,
  faPaintBrush,
  faRobot,
  faStar,
  faUsers
 } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// fontawesome
library.add(
  faBolt,
  faChartLine,
  faCode,
  faPaintBrush,
  faRobot,
  faStar,
  faUsers
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