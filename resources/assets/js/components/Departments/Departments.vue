<template>
    <div>

        <div id="department--container">
            <!--multi value holder holder-->
            <input v-for="email in emails" :name="name+'[]'" type="hidden" :value="email">

            <!--query input field search container-->
            <div style="position:relative" :class="{'has-error': invalidEmail}">
                <i class="add-btn fa fa-plus"
                   @click="insertNewEmail(query)"
                   v-if="showAddButton">
                </i>

                <input id="multiselect"
                       type="text"
                       class="form-control"
                       v-model="query"
                       @keypress="invalidEmail=false"
                       @keyup.27="hideResultsContainer"
                >
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
                <em v-text="user.email"></em>
                <em v-if="user.department">({{user.department}})</em>
            </li>

            <!--fade block-->
            <div id="fade" v-if="showSearchResultBox" @click="hideResultsContainer"></div>
        </div>
    </div>
</template>

<style scoped>
    .add-btn {

        position: absolute;
        z-index: 2;
        top: 50%;
        bottom: 0;
        right: 5px;
        transform: translateY(-50%);
        color: darkgreen;
        cursor: pointer;
    }

    .search-result {

        position: absolute;
        z-index: 2;
        width: 100%;
        border: 1px solid rgba(0,0,0,0.2);
        box-shadow: 0 3px 2px rgba(0,0,0,0.2);
        background: #fff;
        border-bottom-left-radius: 2px;
        border-bottom-right-radius: 2px;
        padding: 0;
    }

    .search-result i.fa.fa-plus {
        position: relative;
        top: 50%;
        right: 5px;
        transform: translateY(-50%);
        display: none;
    }

    .search-result .search--not--found,
    .search-result .department--item {
        padding: 1px 5px;
        margin: 0;
        list-style: none;
        transition: .1s ease-in-out;
    }

    .search-result .department--item,
    .search-result .fa-remove {
        cursor: pointer;
    }

    .search-result .department--item:hover {

        background: #3097D1;
        color: #f5f8fa;
    }

    .search-result .department--item:hover i.fa.fa-plus {
        display: block;
    }


    .selected--department--item {
        padding: 1px 5px;
        margin: 0;
        list-style: none;
        white-space: nowrap;
        transition: .1s ease-in-out;
    }

    .fa-remove {
        color: darkred;
        cursor: pointer;
    }

    .fa-remove:hover{
         transform: scale(1.1);
     }

    .has-error .form-control {
        border-color: #a94442;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.0);
    }

    .has-error .help-block {
        color: #a94442;
    }

    .has-error .help-block,
    .has-error i.fa.fa-plus.add-btn {
        z-index: 2;
        color: #a94442;
    }

    .form-control {
        position: relative;
        z-index: 1;
    }

    #fade {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
</style>

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
                emails: [],
                invalidEmail: false
            }
        },

        props: {
            name: {default: ""},
            showUser: {default: true},
            showDepartment: {default: true},
            value: {default: []}
        },

        mixins: [department, user, addButton],


        mounted() {
            const initialValue = JSON.parse(this.value);
            if (initialValue)
                for(let i=0;i<initialValue.length;i++)
                    this.selected[i] = {email: initialValue[i].email};

            this.setEmails(initialValue);
            this.$on('input_query', _.debounce( () => this.getResults() ,500));
        },

        computed: {

            showSearchResultBox() {
                return this.hasQueryText
                        || this.hasUsers
                        || this.hasDepartment;
            },

            hasQuery,
            hasQueryText
        },

        watch: {
            selected() {
                const self = this;
                const emails = _.map(self.selected, ({email}) => email);
                self.setEmails( emails );
            },

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
             * set emails collection
             * @param emails
             */
            setEmails(emails) {
                this.emails = emails;
            },

            /**
             * @set users collection
             * @set departments collection
             * @param response
             */
            setResult(response) {
                const result = response;
                

                this.setUsers( result.users );
                this.setDepartments( result.departments );
                
                this.queryStatus('success');
                
            },

            /**
             * set departments
             * @param departments
             */
            setDepartments(departments) {
                this.departments = departments;
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
                const newUser = { email };

                if (!this.policeUser(newUser)) {
                    document.getElementById("multiselect").focus();
                    return;
                }

                this.insertToSelectedItem(newUser);
                this.hideResultsContainer();
            },

            /**
             * insert item to selected data
             * @param user
             * @returns {boolean}
             */
            insertToSelectedItem(user) {
                this.selected.push( this.sanitizeUser(user) );
            },

            policeUser(newUser) {
                return this.isNotExist( newUser ) && this.validateEmail(newUser.email);
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