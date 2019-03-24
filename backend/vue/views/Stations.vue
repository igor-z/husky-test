<template>
	<div style="width: 100%">
		<router-link to="/station/add" class="btn btn-primary">Add Station</router-link>

		<table class="table">
			<thead class="thead-dark">
			<tr>
				<th>Name</th>
				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
			<tr v-for="(station, index) in stations">
				<td>{{station.name}}</td>
				<td>
					<a href="#" @click.prevent="deleteStation(index)">Delete</a>
					<a href="#" @click.prevent="updateStation(index)">Update</a>
				</td>
			</tr>
			</tbody>
		</table>

		<pagination :current-page="currentPage" :page-count="pageCount" @page-changed="showPage($event)"/>
	</div>
</template>

<script>
import {mapState} from 'vuex';
import axios from 'axios';
import Vue from 'vue';
import Pagination from '../components/Pagination.vue';

Vue.component('pagination', Pagination);

export default {
    data() {
        return {
            stations: [],
            currentPage: parseInt(this.$route.query.page || 1),
            pageSize: 20,
            pageCount: 1,
        };
    },
    mounted() {
        this.reloadList();
    },
    computed: {
        ...mapState({

        }),
    },
    methods: {
        reloadList() {
            axios.get('/stations', {
                params: {
                    'per-page': this.pageSize,
                    'page': this.currentPage,
                }
            })
                .then(response => {
                    this.stations = response.data;
                    this.currentPage = parseInt(response.headers['x-pagination-current-page']);
                    this.pageSize = parseInt(response.headers['x-pagination-per-page']);
                    this.pageCount = parseInt(response.headers['x-pagination-page-count']);
                });
        },
        deleteStation(index) {
            const station = this.stations[index];

            axios.delete(`/stations/${station.id}`)
                .then(response => {
                    this.stations.splice(index, 1);
                    this.reloadList();
                });
        },
        updateStation(index) {
            const station = this.stations[index];

            this.$router.push(`/station/${station.id}`);
        },
	    showPage(page) {
            this.$router.push({
	            path: '/station/',
	            query: {page: page}
            });

            this.currentPage = page;

            this.reloadList();
	    },
    }
}
</script>