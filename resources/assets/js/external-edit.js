require('./app');
import Departments from './components/Departments/Departments.vue';

const app = new Vue({
    el: "#app",

    components: {
        Departments
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

