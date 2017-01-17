require('./app');
import Departments from './components/Departments/Departments.vue';
import Datepicker from 'vuejs-datepicker';
import Checkbox from './components/Checkbox.vue';

const app = new Vue({
    el: "#app",
    data: {
        requireDepartment: true
    },

    components: {
        Departments,
        Datepicker,
        Checkbox
    },
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

