require('./app');
require('chosen-js');

Vue.component('multi-select', require('./components/Multiselect.vue'));

const app = new Vue({
    el: "#app",
    data:{
        option: ["a","b","c"]
    }
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});


