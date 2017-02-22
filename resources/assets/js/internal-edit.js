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
            if(sel) document.getElementById('categoryInput')
                            .hidden = sel.options[sel.selectedIndex].value != 'add_category';
        },

        /**
         * remedy for the the confusing bug found in the select box when toggling checkbox.vue
         */
        echo() {
            const sel = document.querySelector('#category');
            const selected = sel.selectedIndex;
            setTimeout(() => sel.selectedIndex=selected, 1);
        }
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

