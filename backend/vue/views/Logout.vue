<template></template>

<script>
export default {
    created() {
        this.$store.dispatch('removeAccessToken')
            .then(() => {
                this.$router.push('/');
            });
    }
}
</script>