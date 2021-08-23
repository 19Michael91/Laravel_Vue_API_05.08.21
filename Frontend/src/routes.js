
import Vue from "vue"
import VueRouter from 'vue-router'
import OrganisationList from './components/OrganisationsList'
import CreateOrganisation from './components/CreateOrganisation'
import Login from './components/Login'
import Registration from './components/Registration'
import NotFound from './components/NotFound'

Vue.use(VueRouter);

export default new VueRouter({
	routes: [
    {
      path: '/',
      redirect: '/organisations',
    },
		{
			path: '/login',
			component: Login,
		},
    {
      path: '/registration',
      component: Registration,
    },
		{
			path: '/organisations',
			component: OrganisationList,
		},
    {
      path: '*',
      component: NotFound,
    }
	],
  mode: 'history'
})
