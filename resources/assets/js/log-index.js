require("./app");
import { toUpper, capitalize } from "./modules/stringformatter";
import { telfordStandardDate } from "./modules/dateFormatter";
import Datepicker from 'vuejs-datepicker';

const app = new Vue( {
    el: "#app",

    data: {
        pagination: {},
        searchKey: "",
        date_from: "",
        date_to: "",
        errors: {}
    },

    components: {
        Datepicker
    },

    created() {
        this.fetchInitialLogsDisplay();
    },

    computed: {
        documents() {
            return _.filter(
                this.pagination,
                (o) => o.name.toLowerCase().includes(this.searchKey.toLowerCase())
                    || o.ip.toLowerCase().includes(this.searchKey.toLowerCase())
                    || o.description.toLowerCase().includes(this.searchKey.toLowerCase())
            );
        }
    },

    filters: {
        toUpper,
        capitalize,
        telfordStandardDate
    },

    methods: {

        fetchInitialLogsDisplay() {
            const today = moment();

            this.setDateFrom(today);
            this.setDateTo(today.add(1, 'day'));
            this.fetchByDate();
        },

        fetchByDate() {
            this.emptyErrors();
            const date_from = this.date_from ? this.toDateString(this.date_from) : '';
            const date_to = this.date_to ? this.toDateString(this.date_to) : '';
            const params = { date_from, date_to };

            this.$http.post(laroute.route('log.getByDate'),params)
                .then( ({data}) => this.pagination = data,
                       ({data}) => this.errors = data );
        },

        setDateFrom: function (from) {
            this.date_from = this.toDateString(from);
        },

        setDateTo: function (to) {
            this.date_to = this.toDateString(to);
        },

        toDateString(date) {
            return moment(date).format("gggg-MM-DD HH:mm:ss")
        },

        emptyErrors() {
            this.errors = {};
        }
    }
} );