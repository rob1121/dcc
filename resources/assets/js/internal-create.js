require("./app");

const app = new Vue({
    el: "#app",

    filters: {

        demo(data) {
            console.log($("#" + data).val());
            return data;
        }
    },

    methods: {
        submitForm() {
            $("#form-submit").submit();
        }
    }
});