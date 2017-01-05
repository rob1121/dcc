export default {
    data() {
        return {
            users: {},
        }
    },

    computed: {
        hasUsers() {
            return  ! _.isEmpty( this.users );
        }
    },

    methods: {
        /**
         * set users data
         * @param users
         */
        setUsers(users) {
            this.users = users;
        },

        /**
         * sanitize user info
         * @param user
         * @returns {{email: *, department}}
         */
        sanitizeUser(user) {
            const departments = this.sanitizeDepartment(user.department);
            return {
                email: user.email,
                department: departments
            }
        },

        /**
         * reset users list
         */
        resetUsers() {
            this.users = null;
        }

    }
}