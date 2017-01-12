require('./app');
import Departments from './components/Departments/Departments.vue';

import Datepicker from 'vuejs-datepicker';

Vue.component('my-component', {
    components: {
        Datepicker
    }
});


const app = new Vue({
    el: "#app",
    data: {
        requireDepartment: true
    },
    
    mounted() {
        const isRequired = JSON.parse(document.querySelector("#send_notification[checked]").value);
        this.requireDepartment = isRequired;
    },

    components: {
        Departments,
        Datepicker
    },

    methods: {
        getSendNotification(e) {
            this.requireDepartment = JSON.parse(e.target.value); // convert to boolean using JSON.parse;
        }
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

