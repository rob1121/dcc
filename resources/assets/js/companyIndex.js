require('./app');

const app = new Vue({
    el: "#app",

    data: {
        pagination: {}
    },

    ready() {
        this.setPagination();
    },

    methods: {
        setPagination(data = {page: ""}) {
            this.$http.get("/api/company-spec", data).then(response => this.pagination = response.json());
        }
    }
});