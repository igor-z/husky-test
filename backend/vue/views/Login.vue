<template>
    <div class="container">
		<h1>Login</h1>

	    <form @submit.prevent="submit">
		    <div v-if="errors.length" class="alert alert-danger">
			    <ul>
				    <li v-for="error in errors">{{error.message}}</li>
			    </ul>
		    </div>

		    <div class="form-group">
			    <label>Username</label>
			    <input type="text" class="form-control" name="username" placeholder="username" v-model="username">
		    </div>
		    <div class="form-group">
			    <label>Password</label>
			    <input type="password" class="form-control" name="password" placeholder="password" v-model="password">
		    </div>
		    <button type="submit" class="btn btn-primary">Submit</button>
	    </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            password: null,
            username: null,
            errors: [],
        };
    },
    methods: {
        submit(e) {
            this.errors = [];

            this.$store.dispatch('retrieveAccessToken', {
                username: this.username,
                password: this.password,
            })
                .then(() => {
                    if (this.$route.query && this.$route.query.redirect) {
                        this.$router.push(this.$route.query.redirect);
                    } else {
                        this.$router.push('/');
                    }

                    this.password = '';
                    this.username = '';
                })
                .catch(exception => {
                    exception.response.data.forEach((error) => {
                        this.errors.push(error);
                    });
                });
        },
    }
}
</script>