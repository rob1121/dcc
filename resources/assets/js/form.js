require('./app');
require('chosen-js');

const app = new Vue({
    el: "#app"
});

$(".modal-btn").click(function() {
    $("#form-submit").submit();
});


