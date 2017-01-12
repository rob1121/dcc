export default {
    data() {
        return {
            departments: []
        }

    },

    computed: {
        /**
         * check if departments is not empty
         * @returns {boolean}
         */
        hasDepartment() {
            return  ! _.isEmpty( this.departments );
        }
    },

    methods: {

        /**
         * extract unselected departments from the list
         */
        extractUnselectedDepartment() {
            this.departments = _.difference(this.departments, this.selected);
        },

        /**
         * department presenter: split departments by '|'
         * @param departments
         * @returns {*}
         */
        sanitizeDepartment(departments) {
            if(this.isCollectionOfEmployeeIn( departments ))
                return departments.length > 1 ? departments.join('|') : departments[0];

            else if(_.isEmpty(departments))
                return "new";

            return departments;
        },

        /**
         * check if collection of departments is array
         * @param departments
         * @returns {boolean|*}
         */
        isCollectionOfEmployeeIn( departments ) {
            return _.isArray(departments);
        },

        /**
         * reset departments
         */
        resetDepartments() {
            this.departments = null;
        },

        /**
         * remove user from selected data
         * @param department
         */
        removeToDepartments(department) {
            const index = this.departments.indexOf(department);
            if(index > -1) this.departments.splice(index, 1);
        },
    }
}