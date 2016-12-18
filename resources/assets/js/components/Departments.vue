<template>
    <div id="department--container" @focusout="demo()">

        <div style="position:relative" :class="{'has-error': invalidEmail}">
            <i class="add-btn fa fa-plus"
               v-if="showAddButton"
               @click="insertNewEmail(query)">
            </i>
            <input type="text" class="form-control" v-model="query">
        </div>

        <div :style="'width:'+resultWidth"
             class="search-result"
             v-if="hasResultOrQueryStatus"
        >
            <em><small v-text="text"></small></em>

            <p v-if="hasDepartment"><strong>Departments List:</strong></p>

            <li class="department--item"
                v-for="(departmentEmployee, department) in departments"
                @click="addToSelectedItem(departmentEmployee)">
                <h6><i class='pull-right fa fa-plus'></i> {{department}}</h6>
            </li>

            <p v-if="hasUsers"><strong>Users List:</strong></p>

            <li class="department--item"
                v-for="user in users"
                @click="addToSelectedItem(user.email)">
                <h6>{{user.name}}<i class='pull-right fa fa-plus'></i></h6>
            </li>
        </div>

        <li class="selected--department--item h6" v-for="user in selected">
                <i class='text-right fa fa-remove'  @click="removeToSelectedItem(item)"></i>
                <em>{{user.email}}({{user.department}})</em>
        </li>
    </div>
</template>

<script>

    export default {
        data(){
            return {
                resultWidth: 0,
                query: null,
                text: null,
                departments: {},
                users: {},
                selected: [],
                showAddButton: false,
                invalidEmail: false

            }
        },

        mounted() {
            this.$on('input_query', _.debounce( () => this.getResults() ,500) );
        },

        computed: {
            hasResultOrQueryStatus() {
                return this.hasQueryText
                        || this.hasUsers
                        || this.hasDepartment;
            },

            hasQuery() {
                return ! _.isEmpty( this.query );
            },

            hasQueryText() {
                return ! _.isEmpty( this.text );
            },

            hasUsers() {
                return  ! _.isEmpty( this.users );
            },

            hasDepartment() {
                return  ! _.isEmpty( this.departments );
            }
        },

        watch: {
            query() {
                const self = this;

                self.setResultWidth( self.containerWidth() );
                self.$emit('input_query', self.query);
                self.resetResults();
                self.queryStatus('typing');
                this.setShowAddButton(false);
            }
        },

        methods: {
            checkToShowAddButton() {
                const hasResult = this.hasQuery && (! this.hasUsers && ! this.hasDepartment);
                this.setShowAddButton( hasResult );
            },

            setShowAddButton(bool) {
                this.showAddButton = bool;
            },

            getResults() {
                    if(this.isQueryValid()) {
                        this.queryStatus('searching');
                        this.fetchQuery();
                    }
                    else {
                        this.hideResultsContainer();
                        this.checkToShowAddButton();
                    }
            },

            fetchQuery() {
                const departmentList = laroute.route('department.list');
                const params = { q: this.query };

                this.$http
                    .get( departmentList , { params } )
                    .then( response => {
                        this.setResult( response.data );
                        this.checkToShowAddButton();
                    }, error => console.log(error) );
            },

            setResult(response) {
                const result = JSON.parse( response );

                this.setUsers( result.users );
                this.setDepartments( result.departments );
                this.queryStatus('success');
            },

            queryStatus(status=null) {
                this.text = this.isSuccess(status) || _.isEmpty(status)
                        ? null : `${status}...`
            },

            setQuery(inputQuery=null) {
                this.query = inputQuery;
            },

            isQueryValid() {
                return ! _.isEmpty( this.query )
            },

            isSuccess(status) {
                return status === 'success';
            },

            hideResultsContainer(){
                this.setQuery(null);
                this.queryStatus(null);
                this.resetResults();
                this.setShowAddButton(false);
            },

            setUsers(users) {
                this.users = users;
            },

            setDepartments(departments) {
                this.departments = departments;
            },

            resetResults() {
                this.setDepartments(null);
                this.setUsers(null);
            },

            setResultWidth(width) {
                this.resultWidth = width + 'px'
            },

            containerWidth() {
                return document.getElementById( 'department--container' )
                               .clientWidth;
            },

            addToSelectedItem(users) {
                this.isCollection(users)
                    ? this.insertManyToSelectedItem(users)
                    : this.insertToSelectedItem(users);

                this.hideResultsContainer();
            },

            isCollection(items) {
                return _.isArray(items);
            },

            insertManyToSelectedItem(users) {
                _.map(users, user => this.insertToSelectedItem(user));
            },

            insertNewEmail(email) {
                const status = this.insertToSelectedItem({ email });
                if(status) this.hideResultsContainer();
            },

            insertToSelectedItem(user) {
                if( this.isNotExist(user) && this.validateEmail(user.email) ) {
                    this.selected.push( this.sanitizeUser(user) );
                    return true;
                }
            },

            sanitizeUser(user) {
            const departments = this.sanitizeDepartment(user.department);
                return {
                    email: user.email,
                    department: departments
                }
            },

            sanitizeDepartment(departments) {
                if(_.isArray(departments)) return departments.length > 1 ? departments.split('|') : departments[0];
                if(_.isEmpty(departments)) return "new";

                return departments;
            },

            isNotExist(user) {
                return this.findIndexOnSelectedItem( user ) < 0;
            },

            findIndexOnSelectedItem( user ) {
                 return _.findIndex(this.selected, user);
            },

            removeToSelectedItem(item) {
                const index = this.selected.indexOf(item);
                this.selected.splice(index, 1)
            },

            validateEmail(email) {
                const rule = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                this.invalidEmail = ! rule.test(email);

                return ! this.invalidEmail;
            },

            demo() {
                alert('hi');
            }
        }
    }
</script>