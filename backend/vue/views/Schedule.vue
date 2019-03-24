<template>
    <div style="width: 100%">
	    <router-link to="/schedule/add" class="btn btn-success">Add Schedule Item</router-link>

		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th>Станция отправления</th>
					<th>Время отправления</th>
					<th>Станция прибытия</th>
					<th>Время прибытия</th>
					<th>Время в пути</th>
					<th>Цена билета</th>
					<th>Перевозчик</th>
					<th>График движения</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(item, index) in items">
					<td>{{item.departureStation.name}}</td>
					<td>{{item.departure_time | asDateTime}}</td>
					<td>{{item.arrivalStation.name}}</td>
					<td>{{item.arrival_time | asDateTime}}</td>
					<td>{{item.arrival_time | asInterval(item.departure_time)}}</td>
					<td>{{item.ticket_price}}</td>
					<td>{{item.carrier.name}}</td>
					<td>{{item.schedule | asSchedule}}</td>
					<td>
						<a href="#" @click.prevent="deleteItem(index)">Delete</a>
						&nbsp;
						<a href="#" @click.prevent="updateItem(index)">Update</a>
					</td>
				</tr>
			</tbody>
		</table>

	    <pagination :current-page="currentPage" :page-count="pageCount" @page-changed="showPage($event)"/>
    </div>
</template>

<script>
import axios from 'axios';
import Vue from 'vue';
import Pagination from '../components/Pagination.vue';
import moment from 'moment';

Vue.component('pagination', Pagination);

export default {
	data() {
		return {
		    items: [],
			currentPage: parseInt(this.$route.params.page || 1),
			pageSize: 20,
			pageCount: 1,
		};
	},
	mounted() {
        this.reloadList();
	},
    filters: {
	    asDateTime(time) {
	        return moment(time * 1000).format('YYYY-MM-DD HH:mm:ss');
	    },
	    asSchedule(schedule) {
	        let formattedSchedule = [];

            schedule.forEach(scheduleItem => {
                formattedSchedule.push(scheduleItem.charAt(0).toUpperCase() + scheduleItem.slice(1));
            });

			return formattedSchedule.join(', ');
	    },
	    asInterval(time1, time2) {
            return moment(time1 * 1000).to(time2 * 1000, true);
	    }
    },
	methods: {
        reloadList() {
            axios.get('/schedules', {
                params: {
                    'per-page': this.pageSize,
                    'page': this.currentPage,
	                'expand': 'carrier,departureStation,arrivalStation'
                }
            })
                .then(response => {
                    this.items = response.data;
                    this.currentPage = parseInt(response.headers['x-pagination-current-page']);
                    this.pageSize = parseInt(response.headers['x-pagination-per-page']);
                    this.pageCount = parseInt(response.headers['x-pagination-page-count']);
                });
        },
        updateItem(index) {
            const item = this.items[index];

            this.$router.push(`/schedule/${item.id}`);
        },
        deleteItem(index) {
            const item = this.items[index];

			axios.delete(`/schedules/${item.id}`)
				.then(response => {
				    this.items.splice(index, 1);
				    this.reloadList();
				});
        },
        showPage(page) {
            this.$router.push({
                path: '/schedule',
                query: {page: page}
            });

            this.currentPage = page;

            this.reloadList();
        },
	}
}
</script>