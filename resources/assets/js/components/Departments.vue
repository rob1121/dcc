<template>
    <div id="department--container">
        {{results[0]}}
        <input type="text" class="form-control" v-model="query">
        <div :style="'width:'+resultWidth"
             class="search-result"
             v-if="hasResultOrQueryStatus"
        >
            <em><small v-text="text"></small></em>

            <li class="department--item"
                v-for="(departmentEmployee, department) in results.departments"
                @click="addToSelectedItem(results.departments[department])">
                <h6>{{department}} <i class='pull-right fa fa-plus'></i></h6>
            </li>

            <li class="department--item"
                v-for="user in results.users"
                @click="addToSelectedItem(user)">
                <h6>{{user.name}} <em>({{user.email}})</em> <i class='pull-right fa fa-plus'></i></h6>
            </li>
        </div>

        <!--<li class="selected&#45;&#45;department&#45;&#45;item" v-for="item in selected">-->
            <!--<em>{{item.department}} <i class='pull-right fa fa-remove'  @click="removeToSelectedItem(item)"></i></em>-->
        <!--</li>-->

    </div>
</template>

<script>

    export default {
        data(){
            return {
                resultWidth: 0,
                query: null,
                text: null,
                results: {
                    departments: {},
                    users: {}
                },
                selected: []
            }
        },

        mounted() {
            this.$on('input_query', _.debounce(function (msg) {
                this.searchQuery(msg);
            },1000));
        },

        computed:{
            hasResultOrQueryStatus(){
                return ! _.isEmpty( this.text ) || ! _.isEmpty( this.results.departments ) || ! _.isEmpty( this.results.users )
            }
        },

        watch: {
            query() {
                const self = this;

                self.setResultWidth( self.containerWidth() );
                self.$emit('input_query', self.query);
                self.resetResults();
                self.queryStatus('typing');
            }
        },

        props: ['options'],

        methods: {
            searchQuery() {
                if(this.isQueryValid()) {
                    this.queryStatus('searching');
                    this.fetchQuery();
                } else {
                    this.hideResults();
                }
            },

            fetchQuery() {
                const self = this;

                self.$http.get(laroute.route('department.list'), { params: {
                    q: this.query
                } }).then(
                    response => {
                        self.setResults( response.data );
                        self.queryStatus('success')
                    }, error => console.log(error)
                )
            },

            queryStatus(status=null) {
                this.text = this.isSuccess(status) || _.isEmpty(status)
                        ? null : `${status}...`
            },

            isQueryValid() {
                return ! _.isEmpty( this.query )
            },

            isSuccess(status) {
                return status === 'success';
            },

            hideResults(){
                this.queryStatus(null);
                this.resetResults();
            },

            setResults(results) {
                this.results = JSON.parse(results);
            },

            resetResults() {
                this.setResults.departments = {};
                this.setResults.users = {};
            },

            setResultWidth(width) {
                this.resultWidth = width + 'px'
            },

            containerWidth() {
                return document.getElementById( 'department--container' ).clientWidth;
            },

            addToSelectedItem(item) {
                this.selected.push(item);
                this.hideResults();
            },

            removeToSelectedItem(item) {
                const index = this.selected.indexOf(item);
                this.selected.splice(index, 1)
            }

        }
    }
</script>