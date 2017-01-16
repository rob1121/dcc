require('./app');
import Departments from './components/Departments/Departments.vue';
import Checkbox from './components/Checkbox.vue';

const app = new Vue({
    el: "#app",

    data: {
        requireDepartment: true,
        requireCategoryInputField: true,
    },

    mounted() {
        this.toggleCategoryInputField();
    },

    components: { Departments, Checkbox },

    methods: {

        toggleCategoryInputField() {
            this.requireCategoryInputField = document.querySelector("#category").value === "add_category";
        }
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

