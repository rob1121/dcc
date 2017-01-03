require('./app');
import Departments from './components/Departments/DepartmentList.vue';

const app = new Vue({
    el: "#app",

    data: {
        userType: ""
    },
    
    mounted() {
      this.userType = document.querySelector('#user_type option[selected]').innerHTML;
    },

    data: {
        requirePassword: true
    },

    components: {
        Departments
    },

    methods: {
        togglePassword(e) {
            this.userType = e.target.value;
            this.requirePassword = "EMAIL RECEIVER ONLY" !== this.userType;
        }
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

