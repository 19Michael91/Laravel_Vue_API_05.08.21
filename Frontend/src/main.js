
import Vue from 'vue'
import App from './App'
import router from './routes'
import store from './store'
import axios from 'axios'
import conf from './config'
import rotation from './modules/rotation'

Vue.prototype.$axios = axios;
Vue.prototype.$conf = conf;
Vue.prototype.$user = '';
Vue.prototype.$rotation = rotation;

Vue.config.productionTip = false;

new Vue({
  el: '#app',
  components: { App },
  template: '<App/>',
  router,
  store
});
