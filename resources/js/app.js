import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'

import '~/plugins'
import '~/components'
import './bootstrap'

import jQuery from 'jquery'
window.$ = jQuery

// Animation
import AnimateCSS from 'animate.css';
Vue.use(AnimateCSS);

//Modal
import VModal from 'vue-js-modal'
Vue.use(VModal)

// Vue Event Bus
import VueBus from './eventBus'
Vue.use(VueBus)

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
