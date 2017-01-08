require('./app');
import Departments from './components/Departments/Departments.vue';

const app = new Vue({
    el: "#app",

    data: {
        requireDepartment: true,
        requireCategoryInputField: true
    },

    mounted() {
        this.requireDepartment = JSON.parse(document.querySelector("#send_notification[checked]").value);
        this.toggleCategoryInputField();
    },

    components: { Departments },

    methods: {
        getSendNotification(e) {
            this.requireDepartment = JSON.parse(e.target.value); // convert to boolean using JSON.parse;
        },

        toggleCategoryInputField() {
            this.requireCategoryInputField = document.querySelector("#category").value === "add_category";
        }
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

