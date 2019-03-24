<template>
    <div class="container-fluid" id="app">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<router-link to="/" class="navbar-brand" v-if="isLoggedIn">Schedule</router-link>
			<router-link to="/carrier" class="navbar-brand" v-if="isLoggedIn">Carriers</router-link>
			<router-link to="/station" class="navbar-brand" v-if="isLoggedIn">Stations</router-link>
			<router-link to="/login" class="navbar-brand" v-if="!isLoggedIn">Login</router-link>
			<router-link to="/logout" class="navbar-brand" v-if="isLoggedIn">Logout</router-link>
		</nav>
		<router-view/>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'app',
    computed: {
        isLoggedIn() {
            return this.$store.getters.isLoggedIn;
        }
    },
    created() {
        if (this.$store.getters.isLoggedIn) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.$store.getters.accessToken}`;
        }
    },
}
</script>

<style>
</style>

