import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
		accessToken: localStorage.getItem('accessToken'),
		accessTokenExpiredAt: localStorage.getItem('accessTokenExpiredAt'),
    },
    getters: {
		isLoggedIn(state) {
			if (state.accessToken && state.accessTokenExpiredAt) {
				return Date.parse(state.accessTokenExpiredAt) > Date.now();
			} else {
				return false;
			}
		},
		accessToken(state) {
			return state.accessToken;
		}
    },
    mutations: {
        removeAccessToken(state) {
			localStorage.removeItem('accessToken');
			localStorage.removeItem('accessTokenExpiredAt');
			state.accessToken = null;
			state.accessTokenExpiredAt = null;

			axios.defaults.headers.common['Authorization'] = null;
		},
		saveAccessToken(state, accessToken) {
			localStorage.setItem('accessToken', accessToken.token);
			localStorage.setItem('accessTokenExpiredAt', accessToken.expired);
			state.accessToken = accessToken.token;
			state.accessTokenExpiredAt = accessToken.expired;

			axios.defaults.headers.common['Authorization'] = `Bearer ${accessToken.token}`;
		},
    },
    actions: {
		retrieveAccessToken(context, credentials) {
			return new Promise((resolve, reject) => {
				axios.post('/auth/login', {
					username: credentials.username,
					password: credentials.password
				})
					.then(response => {
						context.commit('saveAccessToken', response.data);
						resolve();
					})
					.catch(error => {
						reject(error);
					});
			});
		},
		removeAccessToken(context) {
			return new Promise((resolve, reject) => {
				axios.post('/auth/logout')
					.then(() => {
						context.commit('removeAccessToken');
						resolve();
					})
					.catch(error => {
						reject(error);
					});
			});
		},
    }
});
