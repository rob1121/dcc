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
            let toggleCategoryField = false;

            const categorySetup = document.querySelector("#category");
            if(categorySetup) toggleCategoryField = categorySetup.value === "add_category";

            return toggleCategoryField;
        },

        toggleCategoryInputField(sel) {
            alert(sel.options[sel.selectedIndex].text);

            this.requireCategoryInputField = this.toggleAddCategoryField();
        }
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

