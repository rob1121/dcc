export default {
    data() {
        return {
            departments: []
        }

    },

    computed: {
        hasDepartment() {
            return  ! _.isEmpty( this.departments );
        }
    },

    methods: {
        setDepartments(departments) {
            this.departments = departments;
        },

        sanitizeDepartment(departments) {
            if(this.isCollectionOfEmployeeIn( departments )){
                return departments.length > 1
                    ? departments.split('|')
                    : departments[0];
            }

            if(_.isEmpty(departments)) return "new";

            return departments;
        },

        isCollectionOfEmployeeIn( departments ) {
            return _.isArray(departments);
        },

        resetDepartments() {
            this.departments = null;
        },

        /**
         * remove user from selected data
         * @param department
         */
        removeToDepartments(department) {
            const index = this.departments.indexOf(department);
            if(index > -1) this.departments.splice(index, 1)
        },
    }
}