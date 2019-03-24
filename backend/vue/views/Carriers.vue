<template>
	<div style="width: 100%">
		<router-link to="/carrier/add" class="btn btn-success">Add Carrier</router-link>

		<table class="table">
			<thead class="thead-dark">
			<tr>
				<th>Name</th>
				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
			<tr v-for="(carrier, index) in carriers">
				<td>{{carrier.name}}</td>
				<td>
					<a href="#" @click.prevent="deleteCarrier(index)">Delete</a>
					<a href="#" @click.prevent="updateCarrier(index)">Update</a>
				</td>
			</tr>
			</tbody>
		</table>

		<pagination :current-page="currentPage" :page-count="pageCount" @page-changed="showPage($event)"/>
	</div>
</template>

<script>
import Vue from 'vue';
import axios from 'axios';
import Pagination from '../components/Pagination.vue';

Vue.component('pagination', Pagination);

export default {
    data() {
        return {
            carriers: [],
            currentPage: parseInt(this.$route.params.page || 1),
            pageSize: 20,
            pageCount: 1,
        };
    },
    mounted() {
        this.reloadList();
    },
	components: {
        Pagination
	},
    methods: {
        reloadList() {
            axios.get('/carriers', {
                params: {
                    'per-page': this.pageSize,
                    'page': this.currentPage,
                }
            })
                .then(response => {
                    this.carriers = response.data;
                    this.currentPage = parseInt(response.headers['x-pagination-current-page']);
                    this.pageSize = parseInt(response.headers['x-pagination-per-page']);
                    this.pageCount = parseInt(response.headers['x-pagination-page-count']);
                });
        },
        deleteCarrier(index) {
            const carrier = this.carriers[index];

            axios.delete(`/carriers/${carrier.id}`)
                .then(response => {
                    this.carriers.splice(index, 1);
                    this.reloadList();
                });
        },
        updateCarrier(index) {
            const carrier = this.carriers[index];

            this.$router.push(`/carrier/${carrier.id}`);
        },
	    showPage(page) {
            this.$router.push({
	            path: '/carrier/',
	            query: {page: page}
            });

            this.currentPage = page;

            this.reloadList();
	    },
    }
}
</script>