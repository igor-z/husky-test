<template>
	<div style="width: 100%">
		<h1>Updating {{id}}</h1>

		<form @submit.prevent="save()">
			<div v-if="errors.length" class="alert alert-danger">
				<ul>
					<li v-for="error in errors">{{error.message}}</li>
				</ul>
			</div>

			<div class="form-group">
				<label>Name</label>
				<input type="text" class="form-control" placeholder="Name" v-model="formData.name">
			</div>

			<button type="submit" class="btn btn-success">Save</button>
		</form>
	</div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                errors: [],
                id: this.$route.params.id || null,
                formData: {
                    name: '',
                },
            };
        },
        mounted() {
            if (this.id) {
                this.load();
            }
        },
        methods: {
            load() {
                axios.get(`/stations/${this.id}`)
                    .then(response => {
                        this.formData = response.data;
                    });
            },
            save() {
                this.errors = [];
                let promise;

                if (this.id) {
                    promise = axios.put(`/stations/${this.id}`, this.formData);
                } else {
                    promise = axios.post('/stations', this.formData);
                }

                promise
                    .then(response => {
                        this.$router.push('/station');
                    })
                    .catch(exception => {
                        this.errors = exception.response.data;
                    });
            },
        }
    }
</script>