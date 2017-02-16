require('./app');

import Departments from './components/Departments/Departments.vue';
import Checkbox from './components/Checkbox.vue';

const app = new Vue({
    el: "#app",

    data: {
        requireDepartment: true,
        requireCategoryInputField: true
    },

    mounted() {
        this.toggleCategoryInputField(
            document.getElementById('category')
        );
    },

    components: { Departments, Checkbox },

    methods: {
        toggleCategoryInputField(sel=null) {
            alert(sel);

            if(sel) document.getElementById('categoryInput')
                            .hidden = sel.options[sel.selectedIndex].value != 'add_category';
        }
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

