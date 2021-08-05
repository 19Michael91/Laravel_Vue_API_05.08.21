
import Vue from 'vue'
import App from './App'
import router from './routes'
import store from './store'
import axios from 'axios'
import conf from './config'

Vue.prototype.$axios = axios;
Vue.prototype.$conf = conf;
Vue.prototype.$user = '';

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  components: { App },
  template: '<App/>',
  router,
  store
})
