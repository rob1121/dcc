<template>
    <div id="department--container">
        <div style="position:relative">
            <input type="text" class="form-control" v-model="query">
            <i class="add-btn fa fa-plus" v-if="showAddButton" @click="insertNewEmail(query)"></i>
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
                <h6>{{department}} <i class='pull-right fa fa-plus'></i></h6>
            </li>

            <p v-if="hasUsers"><strong>Users List:</strong></p>
            <li class="department--item"
                v-for="user in users"
                @click="addToSelectedItem(user.email)">
                <h6>{{user.name}}<i class='pull-right fa fa-plus'></i></h6>
            </li>
        </div>

        <li class="selected--department--item" v-for="item in selected">
            <em>{{item}} <i class='pull-right fa fa-remove'  @click="removeToSelectedItem(item)"></i></em>
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
                showAddButton: false
            }
        },

        mounted() {
            this.$on('input_query', _.debounce(() => this.getResults() ,500));
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
                const self = this;
                const check_result = self.hasQuery && (! self.hasUsers || ! self.hasDepartment);
                self.setShowAddButton( check_result );
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
                    .then( response => {this.setResult(response);this.checkToShowAddButton();
                    }, error    => console.log(error) );
            },

            setResult(response) {
                const result = JSON.parse(response.data);

                this.setUsers( result.users );
                this.setDepartments( result.departments );
                this.queryStatus('success');
            },

            queryStatus(status=null) {
                this.text = this.isSuccess(status) || _.isEmpty(status)
                        ? null : `${status}...`
            },

            setQuery(q=null) {
                this.query = q;
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

            addToSelectedItem(item) {
                this.isCollection(item)
                    ? this.insertManyToSelectedItem(item)
                    : this.insertToSelectedItem(item);

                this.hideResultsContainer();
            },

            isCollection(items) {
                return _.isArray(items);
            },

            insertManyToSelectedItem(users) {
                _.map(users, user => {
                    this.insertToSelectedItem(user)
                });
            },

            insertNewEmail(email) {
                const status = this.insertToSelectedItem(email);
                if(status) this.hideResultsContainer();
            },

            insertToSelectedItem(email) {
//            && this.validateEmail(email)

                email.department.join('|');
                console.log(email.department.join('|'));
                
                if( this.isNotExist(email)) {
                    this.selected.push(email.email);
                    return true;
                }
            },

            isNotExist() {
                return _.indexOf(this.selected, email) < 0;
            },

            removeToSelectedItem(item) {
                const index = this.selected.indexOf(item);
                this.selected.splice(index, 1)
            },

            validateEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                console.log(re.test(email) ? '': "invalid email");
                return re.test(email);
            }
        }
    }
</script>