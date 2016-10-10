import Vue from "vue/dist/vue.js";
import Vuex from "vuex";
import paginationStore from "./../components/paginationStore";

Vue.use(Vuex);

Vue.config.debug = true;

const debug = process.env.NODE_ENV !== "production";

export default new Vuex.Store({
    modules: {
        paginationStore
    },
    strict: debug
});
