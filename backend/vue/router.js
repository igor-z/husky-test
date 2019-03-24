import Vue from 'vue';
import VueRouter from "vue-router";

Vue.use(VueRouter);

export default new VueRouter ({
    routes: [
		{
			path: '/',
			component: () => import('./views/Schedule.vue'),
			meta: {
				authRequired: true,
			}
		},
		{
			path: '/schedule',
			component: () => import('./views/Schedule.vue'),
			meta: {
				authRequired: true,
			}
		},
		{
			path: '/schedule/add',
			component: () => import('./views/ScheduleItem.vue'),
			meta: {
				authRequired: true,
			}
		},
		{
			path: '/schedule/:id',
			component: () => import('./views/ScheduleItem.vue'),
			meta: {
				authRequired: true,
			}
		},
		{
			path: '/carrier',
			component: () => import('./views/Carriers.vue'),
			meta: {
				authRequired: true,
			}
		},
		{
			path: '/carrier/add',
			component: () => import('./views/Carrier.vue'),
			meta: {
				authRequired: true,
			}
		},
		{
			path: '/carrier/:id',
			component: () => import('./views/Carrier.vue'),
			meta: {
				authRequired: true,
			}
		},
		{
			path: '/station',
			component: () => import('./views/Stations.vue'),
			meta: {
				authRequired: true,
			}
		},
		{
			path: '/station/add',
			component: () => import('./views/Station.vue'),
			meta: {
				authRequired: true,
			}
		},
		{
			path: '/station/:id',
			component: () => import('./views/Station.vue'),
			meta: {
				authRequired: true,
			}
		},
		{
			path: '/login',
			component: () => import('./views/Login.vue'),
			meta: {
				guestRequired: true,
			}
		},
		{
			path: '/logout',
			component: () => import('./views/Logout.vue'),
			meta: {
				authRequired: true,
			}
		},
    ]
});