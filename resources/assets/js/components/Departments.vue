<template>
    <div id="department--container">
        <input type="text" class="form-control" v-model="query">
        {{searchResults}}
        <!---->
        <!--<div :style="'width:'+searchResultWidth"-->
             <!--class="search-result"-->
             <!--v-if="hasSearchResultOrQueryStatus"-->
        <!--&gt;-->
            <!--<em><small v-text="text"></small></em>-->

            <!--<li class="department&#45;&#45;item" v-for="options in options" @click="addToSelectedItem(options)">-->
                <!--{{options.department}} <i class='pull-right fa fa-plus'></i>-->
            <!--</li>-->
        <!--</div>-->

        <!--<li class="selected&#45;&#45;department&#45;&#45;item" v-for="item in selected">-->
            <!--<em>{{item.department}} <i class='pull-right fa fa-remove'  @click="removeToSelectedItem(item)"></i></em>-->
        <!--</li>-->
    </div>
</template>

<script>

    export default {
        data(){
            return {
                searchResultWidth: 0,
                query: null,
                text: null,
                searchResults: {},
                selected: []
            }
        },

        mounted() {
            this.$on('input_query', _.debounce(function (msg) {
                this.searchQuery(msg);
            },1000));
        },

        computed:{
            hasSearchResultOrQueryStatus(){
                return ! _.isEmpty( this.text ) || ! _.isEmpty( this.searchResults )
            }
        },

        watch: {
            query() {
                const self = this;

                self.setSearchResultWidth( self.getContainerWidth() );
                self.$emit('input_query', self.query);
                self.setSearchResults(null);
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
                    this.hideSearchResults();
                }
            },

            fetchQuery() {
                const self = this;

                self.$http.get(laroute.route('department.list'), { params: {
                    query: this.query
                } }).then(
                    response => {
                        self.setSearchResults( response.data );
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

            hideSearchResults(){
                this.queryStatus(null);
                this.setSearchResults(null);
            },

            setSearchResults(results) {
                this.searchResults = JSON.parse(results);
            },

            setSearchResultWidth(width) {
                this.searchResultWidth = width + 'px'
            },

            getContainerWidth() {
                const width = document
                    .getElementById( 'department--container' )
                    .clientWidth;

                return width;
            },

            addToSelectedItem(item) {
                this.selected.push(item);
                this.hideSearchResults();
            },

            removeToSelectedItem(item) {
                const index = this.selected.indexOf(item)
                this.selected.splice(index, 1)
            }

        }
    }
</script>