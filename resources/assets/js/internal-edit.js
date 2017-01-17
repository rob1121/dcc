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
        toggleAddCategoryField: function () {
            const categorySetup = document.querySelector("#category");
            if(categorySetup) return categorySetup.value === "add_category";

            return;
        },
        toggleCategoryInputField() {
            this.requireCategoryInputField = this.toggleAddCategoryField();
        }
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

