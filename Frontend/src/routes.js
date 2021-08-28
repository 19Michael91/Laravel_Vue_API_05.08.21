
import Vue from "vue"
import VueRouter from 'vue-router'
import OrganisationList from './components/OrganisationsList'
import UpdateOrganisation from './components/UpdateOrganisation'
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
      path: '/organisations/edit',
      name: 'editOrganisation',
      component: UpdateOrganisation,
    },
    {
      path: '*',
      component: NotFound,
    }
	],
  mode: 'history'
})
