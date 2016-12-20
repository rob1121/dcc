<template>
    <div id="department--container">
        <!--multi value holder holder-->
        <input v-for="email in emails" :name="name+'[]'" type="hidden" :value="email">

        <!--query input field search container-->
        <div style="position:relative" :class="{'has-error': invalidEmail}">
            <i class="add-btn fa fa-plus"
               @click="insertNewEmail(query)"
               v-if="showAddButton">
            </i>

            <input type="text" class="form-control" v-model="query" @keyup.27="hideResultsContainer">

            <span class="help-block" v-if="invalidEmail">Invalid input email</span>
        </div>

        <!--search result container-->
        <div :style="'width:'+resultWidth"
             class="search-result"
             v-if="showSearchResultBox"
        >
            <em><small v-text="text"></small></em>

            <p v-if="hasDepartment" v-show="showDepartment == 'true'"><strong>Departments List:</strong></p>
            <!--department list-->
            <li class="department--item"
                v-if="showDepartment"
                v-for="(departmentEmployee, department) in departments"
                @click="addToSelectedItem(departmentEmployee)">
                <h6><i class='pull-right fa fa-plus'></i> {{department}}</h6>
            </li>

            <p v-if="hasUsers" v-show="showUser == 'true'"><strong>Users List:</strong></p>

            <!--users list-->
            <li class="department--item"
                v-for="user in users"
                v-if="showUser"
                @click="addToSelectedItem(user)">
                <h6>{{user.name}}<i class='pull-right fa fa-plus'></i></h6>
            </li>
        </div>

        <!--selected item list-->
        <li class="selected--department--item h6" v-for="user in selected">
                <i class='text-right fa fa-remove' @click="removeToSelectedItem(user)"></i>
                <em>{{user.email}}({{user.department}})</em>
        </li>

        <!--fade block-->
        <div id="fade" v-if="showSearchResultBox" @click="hideResultsContainer"></div>
    </div>
</template>

<script>
    import department from "./departmentMixins";
    import user from "./userMixins";
    import addButton from "./addButtonMixins";

    import { fetchQuery,
            queryStatus,
            isSuccess,
            setQuery,
            isQueryValid,
            hasQuery,
            hasQueryText,
            getResults } from "./QueryMethods";

    export default {
        data() {
            return {
                resultWidth: 0,
                query: null,
                text: null,
                selected: [],
                invalidEmail: false
            }
        },

        props: {
            name: {default: ""},
            showUser: {default: true},
            showDepartment: {default: true}
        },

        mixins: [department, user, addButton],


        mounted() {
            this.$on('input_query', _.debounce( () => this.getResults() ,500));
        },

        computed: {
            emails() {
                return _.map(this.selected, (user) => user.email);
            },

            showSearchResultBox() {
                return this.hasQueryText
                        || this.hasUsers
                        || this.hasDepartment;
            },
            hasQuery,
            hasQueryText
        },

        watch: {
            query() {
                const self = this;

                self.setResultWidth( self.containerWidth() );
                self.$emit('input_query', self.query);
                self.resetResults();
                self.queryStatus('typing');
                self.setShowAddButton(false);
            }
        },

        methods: {
            fetchQuery,
            queryStatus,
            isSuccess,
            setQuery,
            isQueryValid,
            getResults,

            /**
             * @set users collection
             * @set departments collection
             * @param response
             */
            setResult(response) {
                const result = JSON.parse( response );

                this.setUsers( result.users );
                this.setDepartments( result.departments );
                this.queryStatus('success');
                
            },

            /**
             * hide search result container
             */
            hideResultsContainer() {
                this.setQuery(null);
                this.queryStatus(null);
                this.resetResults();
                this.setShowAddButton(false);
            },

            /**
             * @reset users
             * @reset departments
             */
            resetResults() {
                this.resetDepartments();
                this.resetUsers();
            },

            /**
             * adjust search result container width
             * @param width
             */
            setResultWidth(width) {
                this.resultWidth = width + 'px'
            },

            /**
             * get search result container width
             * @returns {number}
             */
            containerWidth() {
                return document.getElementById( 'department--container' )
                               .clientWidth;
            },

            /**
             * add selected Item by batch or single
             * @param users
             */
            addToSelectedItem(users) {
                this.isCollection(users)
                    ? this.insertManyToSelectedItem(users)
                    : this.insertToSelectedItem(users);

                this.hideResultsContainer();
            },

            /**
             * is item is array collection
             * @param items
             * @returns {boolean|*}
             */
            isCollection(items) {
                return _.isArray(items);
            },

            /**
             * insert data to selected data by batch
             * @param users
             */
            insertManyToSelectedItem(users) {
                _.map(users, user => this.insertToSelectedItem(user));
            },

            /**
             * insert data to selected data by single
             * @param email
             */
            insertNewEmail(email) {
                const status = this.insertToSelectedItem({ email });
                if(status) this.hideResultsContainer();
            },

            /**
             * insert item to selected data
             * @param user
             * @returns {boolean}
             */
            insertToSelectedItem(user) {
                if( this.isNotExist(user) && this.validateEmail(user.email) ) {
                    this.selected.push( this.sanitizeUser(user) );
                    return true;
                }
            },

            /**
             * validate email is unique
             * @param user
             * @returns {boolean}
             */
            isNotExist(user) {
                return this.findIndexOnSelectedItem( user ) < 0;
            },

            /**
             * find index of user in selected data
             * @param user
             * @returns {number}
             */
            findIndexOnSelectedItem( user ) {
                 return _.findIndex(this.selected, {email: user.email});
            },

            /**
             * remove user from selected data
             * @param item
             */
            removeToSelectedItem(item) {
                const index = this.selected.indexOf(item);
                this.selected.splice(index, 1)
            },

            /**
             * validate email
             * @param email
             * @returns {boolean}
             */
            validateEmail(email) {
                const rule = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                this.invalidEmail = ! rule.test(email);

                return ! this.invalidEmail;
            }
        }
    }
</script>