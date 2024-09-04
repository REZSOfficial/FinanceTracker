<template>
    <div>
        <button
            :disabled="!data.prev_page_url"
            @click="changePage(data.prev_page_url)"
        >
            Previous
        </button>

        <span v-for="page in pages" :key="page">
            <button
                :class="{ 'is-active': page === data.current_page }"
                @click="changePage(pageUrl(page))"
            >
                {{ page }}
            </button>
        </span>

        <button
            :disabled="!data.next_page_url"
            @click="changePage(data.next_page_url)"
        >
            Next
        </button>
    </div>
</template>

<script>
export default {
    props: {
        data: Object,
    },
    computed: {
        pages() {
            let pages = [];
            for (let i = 1; i <= this.data.last_page; i++) {
                pages.push(i);
            }
            return pages;
        },
    },
    methods: {
        changePage(url) {
            this.$emit("pagination-change-page", url);
        },
        pageUrl(page) {
            return `${this.data.path}?page=${page}`;
        },
    },
};
</script>

<style>
.is-active {
    font-weight: bold;
}
</style>
