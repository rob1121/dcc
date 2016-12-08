<template>
    <div id="department--container">
        <input type="text" class="form-control" v-model="query">
        <div :style="'width:'+searchResultWidth" class="search-result" v-if="hasSearchResultOrQueryStatus">

            <em><small v-text="text"></small></em>
            <li v-for="result in searchResults" @click="hideSearchResults">
                {{result}}
                <i class="fa fa-add"></i>
            </li>
        </div>
    </div>
</template>

<style>
    .search-result {
        position: absolute;
        z-index: 2;
        width: 100%;
        border: 1px solid rgba(0,0,0,0.2);
        box-shadow: 0 3px 2px rgba(0,0,0,0.2);
        background: #fff;
        border-bottom-left-radius: 2px;
        border-bottom-right-radius: 2px;
        padding: 0 5px 10px 5px;
    }
</style>

<script>

    export default {
        data(){
            return {
                searchResultWidth: 0,
                query: null,
                text: null,
                searchResults: null,
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

                self.$http.get(laroute.route('department.list')).then(
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
                return document.getElementById('department--container').clientWidth
            }

        }
    }
</script>