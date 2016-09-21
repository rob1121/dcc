require('./app');
const app = new Vue({
    el: "#app",

    methods: {
        submitForm() {
            $("#form-submit").submit();
        }
    }
});