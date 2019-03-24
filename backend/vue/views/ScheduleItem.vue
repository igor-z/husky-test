<template>
    <div style="width: 100%">
	    <form @submit.prevent="save()">
		    <div v-if="errors.length" class="alert alert-danger">
			    <ul>
				    <li v-for="error in errors">{{error.message}}</li>
			    </ul>
		    </div>

		    <div class="form-group">
			    <label>Departure station</label>
			    <select class="custom-select" name="departure_station_id" v-model="formData.departure_station_id">
				    <option v-for="station in stations" :value="station.id">{{station.name}}</option>
			    </select>
		    </div>

		    <div class="form-group">
			    <label>Departure time</label>
			    <input type="datetime-local" class="form-control" name="departure_time" placeholder="Departure time" v-model="formData.departure_time">
		    </div>

		    <div class="form-group">
			    <label>Arrival station</label>
			    <select class="custom-select" name="arrival_station_id" v-model="formData.arrival_station_id">
				    <option v-for="station in stations" :value="station.id">{{station.name}}</option>
			    </select>
		    </div>

		    <div class="form-group">
			    <label>Arrival time</label>
			    <input type="datetime-local" class="form-control" name="arrival_time" placeholder="Arrival time" v-model="formData.arrival_time">
		    </div>

		    <div class="form-group">
			    <label>Ticket price</label>
			    <input type="text" class="form-control" name="ticket_price" placeholder="Ticket price" v-model="formData.ticket_price">
		    </div>

		    <div class="form-group">
			    <label>Carrier</label>
			    <select class="custom-select" name="carrier_id" v-model="formData.carrier_id">
				    <option v-for="carrier in carriers" :value="carrier.id">{{carrier.name}}</option>
			    </select>
		    </div>

		    <div class="form-group">
			    <label>Schedule</label>
			    <div>
				    <label v-for="weekday in weekdays">
				        <input type="checkbox" :value="weekday.toLowerCase()" v-model="formData.schedule">
					    {{weekday}}
					    &nbsp;
				    </label>
			    </div>
		    </div>

		    <button type="submit" class="btn btn-success">Save</button>
	    </form>
    </div>
</template>

<script>
import moment from 'moment';
import axios from 'axios';

export default {
	data() {
        return {
            weekdays: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            errors: [],
            stations: [],
			carriers: [],
	        id: this.$route.params.id || null,
	        formData: {
                departure_station_id: 0,
                departure_time: '',
                arrival_station_id: 0,
                arrival_time: '',
                ticket_price: 0,
                carrier_id: 0,
                schedule: [],
	        },
        };
	},
	mounted() {
        this.fetchCarriers();
        this.fetchStations();

        if (this.id) {
            this.load();
        }
	},
	methods: {
        fetchStations() {
            axios.get('/stations')
	            .then(response => {
	                this.stations = response.data;
	            });
        },
		fetchCarriers() {
            axios.get('/carriers')
	            .then(response => {
	                this.carriers = response.data;
	            });
		},
        load() {
            axios.get(`/schedules/${this.id}`)
                .then(response => {
                    this.formData = response.data;
                    this.formData.departure_time = moment(this.formData.departure_time * 1000).format('YYYY-MM-DDTHH:mm');
                    this.formData.arrival_time = moment(this.formData.arrival_time * 1000).format('YYYY-MM-DDTHH:mm');
                });
        },
		save() {
            this.errors = [];

            let formData = Object.assign({}, this.formData);
            formData.departure_time = Date.parse(formData.departure_time) / 1000;
            formData.arrival_time = Date.parse(formData.arrival_time) / 1000;

            let promise;

            if (this.id) {
                promise = axios.put(`/schedules/${this.id}`, formData);
            } else {
                promise = axios.post('/schedules', formData);
            }

            promise
	            .then(response => {
	                this.$router.push('/schedule');
	            })
                .catch(exception => {
                    this.errors = exception.response.data;
                })
		},
	}
}
</script>