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
        this.$http.get(laroute.route('log.all')).then(
            ({data}) => this.pagination = JSON.parse(data));
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
        fetchByDate() {
            const params = {
                date_from: this.date_from ? moment(this.date_from).format("gggg-MM-DD HH:mm:ss") : '',
                date_to: this.date_to ? moment(this.date_to).format("gggg-MM-DD HH:mm:ss") : ''
            };

            this.$http.post(laroute.route('log.getByDate'),params)
                .then( ({data}) =>console.log(data),
                       ({data}) => this.errors = JSON.parse(data) );
            
        }
    }
} );