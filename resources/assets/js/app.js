
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
import filters from "./mixins/filters";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('dcc-input', require('./components/Input.vue'));
Vue.component('dcc-textarea', require('./components/Textarea.vue'));
Vue.component('dcc-button', require('./components/Button.vue'));
Vue.component('dcc-datepicker', require('./components/Datepicker.vue'));
Vue.component('dcc-modal', require('./components/Modal.vue'));
Vue.component('dcc-pulse', require('vue-spinner/src/PulseLoader.vue'));

const nav = new Vue({
    el: 'nav',

    mixins: [filters],

    data: {
        showResultDialog: false,
        searchKeyword: "",
        searchResults: []
    },

    computed: {
        isSearchResultNotEmpty() {
            return this.searchResults.length > 0;
        },
    },

    methods: {
        displaySearchResult() {
            this.$http.get(`${env_server}/search?q=${this.searchKeyword}`)
                .then(response => {
                    this.searchResults = response.json();
                    this.toggleSearchResult();
                });
        },

        toggleSearchResult() {
            this.showResultDialog = true;
        },

        closeResultDialog() {
            this.showResultDialog =false;
            this.searchResults = [];
            this.searchKeyword = "";
        }
    }
});
