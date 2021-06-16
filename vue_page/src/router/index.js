import Vue from 'vue'
import VueRouter from 'vue-router'
import index from '../components/Index.vue'
import axios from 'axios'
import qs from 'qs'

Vue.use(VueRouter)
Vue.use(qs)
Vue.prototype.$axios = axios

// const routes = [{
// 		path: '/Index',
// 		component: index
// 	}
// ]

const router = new VueRouter({
	routes: [{
		path: '/',
		redirect: '/index',
		meta: {
			title: '许愿墙'
		}
	}, {
		path: '/Index',
		component: index,
		meta: {
			title: '许愿墙'
		}
	}]
})

export default router
