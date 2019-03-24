<template>
	<nav aria-label="Page navigation" v-if="pageCount > 1">
		<ul class="pagination">
			<li class="page-item" v-if="currentPage > 1">
				<a class="page-link" href="#" @click.prevent="$emit('page-changed', currentPage - 1)">Previous</a>
			</li>

			<li class="page-item " v-for="page in pageCount" :class="{active: page === currentPage}">
				<a class="page-link" href="#" @click.prevent="$emit('page-changed', page)">{{page}}</a>
			</li>

			<li class="page-item" v-if="currentPage < pageCount">
				<a class="page-link" href="#" @click.prevent="$emit('page-changed', currentPage + 1)">Next</a>
			</li>
		</ul>
	</nav>
</template>

<script>
export default {
    props: ['currentPage', 'pageCount'],
};
</script>