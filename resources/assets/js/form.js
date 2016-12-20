require('./app');
import Departments from './components/Departments/DepartmentList.vue';

const app = new Vue({
    el: "#app",

    components: {
        Departments
    },
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

