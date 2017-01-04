require('./app');
import Departments from './components/Departments/DepartmentList.vue';

const app = new Vue({
    el: "#app",

    data: {
        userType: "",
        requirePassword: true
    },
    
    mounted() {
        const option = document.querySelector('#user_type option[selected]');

        this.userType = option
            ? option.innerHTML
            : document.querySelector('#user_type').firstElementChild.innerHTML;

        this.setPasswordRule();
    },

    components: {
        Departments
    },

    methods: {
        togglePassword(e) {
            this.userType = e.target.value;
            this.setPasswordRule();
        },

        setPasswordRule() {
            this.requirePassword = "EMAIL RECEIVER ONLY" !== this.userType;
        }
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});

