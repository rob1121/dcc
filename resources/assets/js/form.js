require('./app');
import Departments from './components/Departments.vue';

const app = new Vue({
    el: "#app",

    components: {
        Departments
    },

    methods: {
        try123:_.debounce(() =>console.log('ss'), 1000)
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

