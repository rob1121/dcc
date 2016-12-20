<template>
    <div id="department--container">
        <!--multi value holder holder-->
        <!--<input v-for="email in emails" :name="name+'[]'" type="hidden" :value="email">-->

        <!--query input field search container-->
        <div style="position:relative">
            <i class="add-btn fa fa-plus"
               @click="insertToSelectedItem(query)"
               v-if="showAddButton">
            </i>

            <input type="text"
                   class="form-control"
                   v-model="query"
                   @keyup.27="hideResultsContainer"
                   @focus="displayListBox">
        </div>

        <!--search result container-->
        <div :style="'width:'+resultWidth"
             class="search-result"
             v-if="showListBox"
        >

            <!--department list-->
            <li class="department--item"
                v-for="department in foundQueryInDepartmentsList"
                @click="insertToSelectedItem(department)">
                <h6><i class='pull-right fa fa-plus'></i> {{department}}</h6>
            </li>

            <h6  class="search--not--found text-danger" v-if="! hasFoundQueryInDepartmentsList"><em>No department matched your input</em></h6>
        </div>

        <!--department list-->
        <li class="selected--department--item h6" v-for="department in selected">
            <i class='text-right fa fa-remove' @click="removeToSelectedItem(department)"></i>
            <em>{{department}}</em>
        </li>

        <!--fade block-->
        <div id="fade" v-if="showListBox" @click="hideResultsContainer"></div>
    </div>
</template>

<script>
    import department from "./departmentMixins";
    import { isSuccess,
             setQuery,
             isQueryValid,
             hasQuery,
             hasQueryText } from "./QueryMethods";

    export default {
        data() {
            return {
                resultWidth: 0,
                query: "",
                selected: [],
                showListBox: false,
                showAddButton: false
            }
        },

        mounted() {
            this.setDepartments( JSON.parse(this.departmentsList) );
        },

        props: {
            name: {default: ""},
            departmentsList: {default: []},
        },

        mixins: [department],

        computed: {

            hasFoundQueryInDepartmentsList() {
                return ! _.isEmpty(this.foundQueryInDepartmentsList);
            },

            foundQueryInDepartmentsList() {
                const self = this;

                return _.orderBy(
                    _.filter( self.departments, d => d.includes(self.query)),null,'asc'
                );
            },

            showSearchResultBox() {
                return this.hasQueryText
                        || this.hasUsers
                        || this.hasDepartment;
            },
            hasQuery,
            hasQueryText,
        },

        watch: {
            query() {
                const self = this;
                self.getResults();
                self.setShowListBox(false);
                self.displayAddButton();
            }
        },

        methods: {
            isSuccess,
            setQuery,
            isQueryValid,

            displayAddButton() {
                const displayAddButton = ! this.hasFoundQueryInDepartmentsList && this.hasQuery;
                this.setShowAddButton( displayAddButton );
            },

            setShowAddButton(bool) {
                this.showAddButton = bool;
            },

            getResults() {
                this.setResultWidth( this.containerWidth() );
            },

            displayListBox() {
                this.setShowListBox(true);
                this.getResults();
            },

            /**
             * hide search result container
             */
            hideResultsContainer() {
                this.setQuery("");
                this.setShowAddButton(false);
                this.setShowListBox(false);
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
             * insert item to selected data
             * @param department
             * @returns {boolean}
             */
            insertToSelectedItem(department) {
                
                if( this.isNotExist( department )) {
                    this.removeToDepartments(department);
                    this.selected.push( department );
                }
                
                this.setQuery("");
                this.setShowListBox(false);

            },

            setShowListBox(bool) {
                this.showListBox = bool;
            },

            /**
             * validate department is unique
             * @param department
             * @returns {boolean}
             */
            isNotExist(department) {
                return _.indexOf(this.selected, department) < 0;
            },

            /**
             * remove user from selected data
             * @param department
             */
            removeToSelectedItem(department) {
                const selectedIndex = this.selected.indexOf(department);
                this.selected.splice(selectedIndex, 1);

                const departmentIndex = this.departmentsList.indexOf(department);
                if(departmentIndex > -1) this.departments.push( department );
            },
        }
    }
</script>